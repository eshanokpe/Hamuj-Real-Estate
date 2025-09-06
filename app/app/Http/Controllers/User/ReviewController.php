<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function index(Property $property): JsonResponse
    { 
        $reviews = $property->reviews()->with('user')->latest()->get();
        
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
            })
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:add_properties,id',
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'property_id' => $validated['property_id'],
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'data' => [
                'id' => $review->id,
                'reviewer_name' => auth()->user()->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'date' => $review->created_at->toISOString(),
                'property_id' => $review->property_id,
                'user_id' => $review->user_id,
            ]
        ], 201);
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