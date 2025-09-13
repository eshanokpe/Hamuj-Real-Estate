<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Log;
use DB;
use Illuminate\Http\JsonResponse;
use App\Models\AddProperty;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;




 
class AddPropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }  

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse // ✅ Now using correct JsonResponse
    {
        try { 
            $user = Auth::user(); 
            // Get all properties for the authenticated user
            $properties = AddProperty::with(['user', 'reviews.user'])
                // ->whereHas('user')
                ->orderBy('created_at', 'desc')
                ->get();
            $userProperties = AddProperty::with('user')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            
            // Transform properties with media URLs
            $transformedProperties = $properties->map(function ($property) {
               
                return [
                    'id' => $property->id,
                    'user' => $property->user ? [ // Check if user exists
                        'id' => $property->user->id,
                        'name' => $property->user->full_name,
                        'email' => $property->user->email,
                        'first_name' => $property->user->first_name,
                        'last_name' => $property->user->last_name,
                        'profile_image' => $property->user->profile_image,
                    ] : null,
                    'title' => $property->title,
                    'description' => $property->description,
                    'price' => (float) $property->price,
                    'location' => $property->location,
                    'caption' => $property->caption,
                    'media_path' => $property->media_path,
                    'media_url' => $property->media_path ? asset('storage/' . $property->media_path) : null,
                    'media_type' => $property->media_type,
                    'mime_type' => $property->mime_type,
                    'reviews' => $property->reviews->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'rating' => (float) $review->rating,
                            'comment' => $review->comment,
                            'user' => $review->user ? [
                                'id' => $review->user->id,
                                'name' => $review->user->full_name,
                                'first_name' => $review->user->first_name,
                                'last_name' => $review->user->last_name,
                                'profile_image' => $review->user->profile_image,
                            ] : null,
                            'created_at' => $review->created_at->toISOString(),
                            'updated_at' => $review->updated_at->toISOString(),
                        ];
                    }),
                    'average_rating' => (float) $property->reviews->avg('rating') ?: 0.0,
                    'reviews_count' => $property->reviews->count(),
                    'created_at' => $property->created_at->toISOString(),
                    'updated_at' => $property->updated_at->toISOString(),
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Properties retrieved successfully',
                'data' => $transformedProperties,
                'user_properties' => $userProperties,
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching properties: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve properties',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            // 'user_id' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            // 'caption' => 'required|string|max:500',
            'mediaType' => 'required|in:image,video',
            'media' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240' // 10MB max
        ]);
        $user = auth()->user();
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle file upload
            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('properties', $fileName, 'public');
                
                $mediaType = $request->mediaType;
                $mimeType = $file->getMimeType();
                
                // Validate media type consistency
                if (($mediaType === 'image' && !str_contains($mimeType, 'image')) ||
                    ($mediaType === 'video' && !str_contains($mimeType, 'video'))) {
                    return response()->json([
                        'message' => 'Media type does not match file content'
                    ], 422);
                }
            }

            // Create property
            $property = AddProperty::create([
                'title' => $request->title,
                'user_id' =>  $user->id,
                'description' => $request->description,
                'price' => $request->price,
                'location' => $request->location,
                // 'caption' => $request->caption,
                'caption' => 'caption',
                'media_path' => $filePath,
                'media_type' => $mediaType,
                'mime_type' => $mimeType
            ]);

            return response()->json([
                'message' => 'Property created successfully',
                'property' => $property
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating property: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AddProperty $property)
    {
        return response()->json($property->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AddProperty $property)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'location' => 'sometimes|required|string|max:255',
            'caption' => 'sometimes|required|string|max:500',
            'mediaType' => 'sometimes|required|in:image,video',
            'media' => 'sometimes|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only(['title', 'description', 'price', 'location', 'caption']);

            // Handle file upload if provided
            if ($request->hasFile('media')) {
                // Delete old file
                if ($property->media_path && Storage::disk('public')->exists($property->media_path)) {
                    Storage::disk('public')->delete($property->media_path);
                }

                $file = $request->file('media');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('properties', $fileName, 'public');
                
                $data['media_path'] = $filePath;
                $data['media_type'] = $request->mediaType;
                $data['mime_type'] = $file->getMimeType();
            }

            $property->update($data);

            return response()->json([
                'message' => 'Property updated successfully',
                'property' => $property
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating property: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        try {
            // Find the property by ID
            $property = AddProperty::find($id);
            
            // Check if property exists
            if (!$property) {
                return response()->json([
                    'message' => 'Property not found'
                ], 404);
            }

            // Check if user owns the property or has permission to delete
             $user = Auth::user(); 
            
            if ($property->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Unauthorized: You can only delete your own properties'
                ], 403);
            }

            // Delete associated file
            if ($property->media_path && Storage::disk('public')->exists($property->media_path)) {
                Storage::disk('public')->delete($property->media_path);
            }

            $property->delete();

            return response()->json([
                'message' => 'Property deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting property: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload media for property (alternative endpoint)
     */
    public function upload(Request $request)
    {
        return $this->store($request);
    }

    
 
}