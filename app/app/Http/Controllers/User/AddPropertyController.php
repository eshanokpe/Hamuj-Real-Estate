<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Log;
use DB;
use Illuminate\Http\JsonResponse;
use App\Models\PostPropertyMedia;
use App\Models\PropertyType;
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
    public function index(Request $request): JsonResponse
    { 
        try { 
            $user = Auth::user(); 
            
            // Get all properties with their media, user, and reviews
            $properties = AddProperty::with(['user', 'reviews.user', 'media'])
                ->orderBy('created_at', 'desc')
                ->get();
                
            // Get user-specific properties
            $userProperties = AddProperty::with(['user', 'media'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Transform all properties with proper data types
            $transformedProperties = $properties->map(function ($property) {
                // Transform media files
                $media = $property->media->map(function ($mediaItem) {
                    return [
                        'id' => (int) $mediaItem->id,
                        'media_path' => $mediaItem->media_path,
                        'media_url' => asset('storage/' . $mediaItem->media_path),
                        'media_type' => $mediaItem->media_type,
                        'mime_type' => $mediaItem->mime_type,
                    ];
                });
            
                // Transform reviews
                $reviews = $property->reviews->map(function ($review) {
                    return [
                        'id' => (int) $review->id,
                        'rating' => (float) $review->rating,
                        'comment' => $review->comment,
                        'user' => $review->user ? [
                            'id' => (int) $review->user->id,
                            'name' => $review->user->full_name,
                            'first_name' => $review->user->first_name,
                            'last_name' => $review->user->last_name,
                            'profile_image' => $review->user->profile_image,
                        ] : null,
                        'created_at' => $review->created_at->toISOString(),
                        'updated_at' => $review->updated_at->toISOString(),
                    ];
                });

                return [
                    'id' => (int) $property->id,
                    'user' => $property->user ? [
                        'id' => (int) $property->user->id,
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
                    'media' => $media,
                    'reviews' => $reviews,
                    'average_rating' => (float) $property->reviews->avg('rating') ?: 0.0,
                    'reviews_count' => (int) $property->reviews->count(),
                    'created_at' => $property->created_at->toISOString(),
                    'updated_at' => $property->updated_at->toISOString(),
                ];
            });
            
            // Transform user properties with consistent data types
            $transformedUserProperties = $userProperties->map(function ($property) {
                // Transform media files
                $media = $property->media->map(function ($mediaItem) {
                    return [
                        'id' => (int) $mediaItem->id,
                        'property_id' => (int) $mediaItem->property_id,
                        'media_path' => $mediaItem->media_path,
                        'media_url' => asset('storage/' . $mediaItem->media_path),
                        'media_type' => $mediaItem->media_type,
                        'mime_type' => $mediaItem->mime_type,
                        'created_at' => $mediaItem->created_at->toISOString(),
                        'updated_at' => $mediaItem->updated_at->toISOString(),
                    ];
                });
                
                return [
                    'id' => (int) $property->id,
                    'user_id' => (int) $property->user_id,
                    'title' => $property->title,
                    'description' => $property->description,
                    'price' => (float) $property->price,
                    'location' => $property->location,
                    'caption' => $property->caption,
                    'media_path' => $property->media_path,
                    'media_type' => $property->media_type,
                    'mime_type' => $property->mime_type,
                    'is_favorite' => (bool) $property->is_favorite,
                    'favorite_count' => (int) $property->favorite_count,
                    'created_at' => $property->created_at->toISOString(),
                    'updated_at' => $property->updated_at->toISOString(),
                    'user' => $property->user ? [
                        'id' => (int) $property->user->id,
                        'first_name' => $property->user->first_name,
                        'last_name' => $property->user->last_name,
                        'email' => $property->user->email,
                        'is_admin' => (bool) $property->user->is_admin,
                        'profile_image' => $property->user->profile_image,
                    ] : null,
                    'media' => $media,
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Properties retrieved successfully',
                'data' => $transformedProperties,
                'user_properties' => $transformedUserProperties,
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching properties: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
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
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'media' => 'required|array',
            'media.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240'
        ]);
        
        $user = auth()->user();
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create property first
            $property = AddProperty::create([
                'title' => $request->title,
                'user_id' => $user->id,
                'description' => $request->description,
                'price' => $request->price,
                'location' => $request->location,
                'caption' => 'caption',
            ]);

            // Handle multiple file uploads
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('properties', $fileName, 'public');
                    
                    $mimeType = $file->getMimeType();
                    $mediaType = str_contains($mimeType, 'image') ? 'image' : 'video';
                    
                    // Create media record associated with the property
                    PostPropertyMedia::create([
                        'property_id' => $property->id,
                        'media_path' => $filePath,
                        'media_type' => $mediaType,
                        'mime_type' => $mimeType
                    ]);
                }
            }

            // Load media with the property response
            $property->load('media');

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
    public function show($id)
    {
        try {
            $property = AddProperty::with(['user', 'reviews.user', 'media'])->findOrFail($id);
            
            // Transform media files
            $media = $property->media->map(function ($mediaItem) {
                return [
                    'id' => $mediaItem->id,
                    'media_path' => $mediaItem->media_path,
                    'media_url' => asset('storage/' . $mediaItem->media_path),
                    'media_type' => $mediaItem->media_type,
                    'mime_type' => $mediaItem->mime_type,
                ];
            });
            
            $propertyData = [
                'id' => $property->id,
                'user' => $property->user ? [
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
                'media' => $media,
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
            
            return response()->json($propertyData);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Property not found: ' . $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'location' => 'sometimes|required|string|max:255',
            'caption' => 'sometimes|required|string|max:500',
            'media' => 'sometimes|array',
            'media.*' => 'sometimes|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $property = AddProperty::findOrFail($id);
            $data = $request->only(['title', 'description', 'price', 'location', 'caption']);

            // Handle file upload if provided
            if ($request->hasFile('media')) {
                // Delete old media files
                foreach ($property->media as $mediaItem) {
                    if (Storage::disk('public')->exists($mediaItem->media_path)) {
                        Storage::disk('public')->delete($mediaItem->media_path);
                    }
                    $mediaItem->delete();
                }

                // Add new media files
                foreach ($request->file('media') as $file) {
                    $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('properties', $fileName, 'public');
                    
                    $mimeType = $file->getMimeType();
                    $mediaType = str_contains($mimeType, 'image') ? 'image' : 'video';
                    
                    PostPropertyMedia::create([
                        'property_id' => $property->id,
                        'media_path' => $filePath,
                        'media_type' => $mediaType,
                        'mime_type' => $mimeType
                    ]);
                }
            }

            $property->update($data);
            $property->load('media');

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

    public function destroy($id)
    {
        \Log::info('Delete property request received', [
            'property_id' => $id,
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'time' => now()
        ]);

        try { 
            // Find the property by ID with its media
            $property = AddProperty::with('media')->find($id);
            
            // Check if property exists
            if (!$property) {
                \Log::warning('Property not found', ['property_id' => $id]);
                return response()->json([
                    'message' => 'Property not found'
                ], 404);
            }

            // Check if user owns the property
            $user = auth()->user();
            $propertyUserId = (int) $property->user_id;
            $currentUserId = (int) $user->id;
            
            if ($propertyUserId !== $currentUserId) {
                \Log::warning('Unauthorized delete attempt', [
                    'property_id' => $id,
                    'property_owner' => $propertyUserId,
                    'attempted_by' => $currentUserId
                ]);
                
                return response()->json([
                    'message' => 'Unauthorized: You can only delete your own properties',
                ], 403);
            }

            // Delete associated media files
            foreach ($property->media as $mediaItem) {
                if ($mediaItem->media_path && Storage::disk('public')->exists($mediaItem->media_path)) {
                    Storage::disk('public')->delete($mediaItem->media_path);
                }
            }

            $property->delete();

            \Log::info('Property deleted successfully', ['property_id' => $id]);

            return response()->json([
                'message' => 'Property deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error deleting property', [
                'property_id' => $id,
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'message' => 'Error deleting property: ' . $e->getMessage()
            ], 500);
        }
    }

    public function upload(Request $request)
    {
        return $this->store($request);
    }

    public function toggleFavorite($id)
    {
        try {
            $property = AddProperty::findOrFail($id);
            $user = Auth::user();

            // Check if user already favorited this property
            $existingFavorite = DB::table('property_favorites')
                ->where('property_id', $property->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingFavorite) {
                // Remove from favorites
                DB::table('property_favorites')
                    ->where('property_id', $property->id)
                    ->where('user_id', $user->id)
                    ->delete();

                // Decrement favorite count
                $property->decrement('favorite_count');
                $isFavorite = false;
            } else {
                // Add to favorites
                DB::table('property_favorites')->insert([
                    'property_id' => $property->id,
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Increment favorite count
                $property->increment('favorite_count');
                $isFavorite = true;
            }

            // Refresh the property to get updated favorite count
            $property->refresh();

            return response()->json([
                'success' => true,
                'message' => $isFavorite ? 'Added to favorites' : 'Removed from favorites',
                'data' => [
                    'is_favorite' => $isFavorite,
                    'favorite_count' => (int)$property->favorite_count
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle favorite: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getFavoriteStatus($id)
    {
        try {
            $property = AddProperty::findOrFail($id);
            $user = Auth::user();

            $isFavorite = DB::table('property_favorites')
                ->where('property_id', $property->id)
                ->where('user_id', $user->id)
                ->exists();

            return response()->json([
                'success' => true,
                'data' => [
                    'is_favorite' => $isFavorite,
                    'favorite_count' => $property->favorite_count
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get favorite status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function propertyType(Request $request)
    {
        try {
            $propertyTypes = PropertyType::all();
            
            if ($propertyTypes->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No property types found',
                    'data' => []
                ], 404);
            }

            if ($request->ajax() || $request->is('api/*')) {
                return response()->json([
                    'status' => true,
                    'message' => 'Property Types fetched successfully',
                    'data' => $propertyTypes
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching property types: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}