<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\AddProperty;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function index($addPropertyId): JsonResponse
    { 
        $reviews = Review::with('user')
        ->where('property_id', $addPropertyId)
        ->latest()
        ->get();
        
        return response()->json([
            'data' => $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'reviewer_name' => $review->user->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'date' => $review->created_at->toISOString(),
                    'property_id' => $review->property_id,
                    'user_id' => $review->user_id,
                ];
            })->toArray()
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $recentReviewsCount = Review::where('user_id', auth()->id())
        ->where('created_at', '>', now()->subHour())
        ->count();

        
        $validated = $request->validate([
            'property_id' => 'required|exists:add_properties,id',
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'required|string|max:1000',
            'reviewer_name' => 'required|string',
        ]);


        // Check if user already reviewed this property
        $existingReview = Review::where('property_id', $validated['property_id'])
            ->where('user_id', auth()->id())
            ->first();

         if ($existingReview) {
            return response()->json([
                'message' => 'You have already reviewed this property.',
                'existing_review' => [
                    'id' => $existingReview->id,
                    'reviewer_name' => auth()->user()->name,
                    'rating' => $existingReview->rating,
                    'comment' => $existingReview->comment,
                    'date' => $existingReview->created_at->toISOString(),
                ]
            ], 409); // 409 Conflict status code
        }

        $review = Review::create([
            'property_id' => $validated['property_id'],
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'reviewer_name' => $validated['reviewer_name'],
        ]);

        return response()->json([
            'data' => [
                'id' => $review->id,
                'reviewer_name' => $review->reviewer_name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'date' => $review->created_at->toISOString(),
                'property_id' => $review->property_id,
                'user_id' => $review->user_id,
            ]
        ], 200);
    }

    public function update(Request $request, Review $review): JsonResponse
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'sometimes|numeric|min:1|max:5',
            'comment' => 'sometimes|string|max:1000',
        ]);

        $review->update($validated);

        return response()->json([
            'data' => [
                'id' => $review->id,
                'reviewer_name' => $review->user->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'date' => $review->created_at->toISOString(),
                'property_id' => $review->property_id,
                'user_id' => $review->user_id,
            ]
        ]);
    }

    public function destroy(Review $review): JsonResponse
    {
        $this->authorize('delete', $review);
        
        $review->delete();

        return response()->json(null, 204);
    }
}