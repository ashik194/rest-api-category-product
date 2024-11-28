<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
        //
        try{
            $reviews = ProductReview::where('product_id', $productId)
                ->with('user:id,name')
                ->latest()
                ->paginate(10);

            return response()->json([
                'reviews' => $reviews,
                'average_rating' => $this->calculateAverageRating($productId)
            ]);
        } catch(Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        //
        // try{
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5'
            ]);

            $product = Product::findOrFail($productId);

            $existingReview = ProductReview::where([
                'user_id'   => $request->user_id,
                'product_id' => $productId
            ])->first();

            if ($existingReview) {
                return response()->json([
                    'message' => 'You have already reviewed this product'
                ], 400);
            }

            // Create review
            $review = ProductReview::create([
                'product_id' => $productId,
                'user_id'   => $request->user_id,
                'rating'    => $validated['rating'],
                'comment'   => $request->comment
            ]);

            return response()->json([
                'review' => $review,
                'message' => 'Review created successfully'
            ], 201);
        // } catch (Exception $e) {
        //     return response()->json($e->getMessage());
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $reviewId)
    {
        //
        try{
            $review = ProductReview::findOrFail($reviewId);

            $validated = $request->validate([
                'rating' => 'integer|min:1|max:5',
            ]);

            $review->update($validated);

            return response()->json([
                'review'    => $review,
                'message'   => 'Review updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function calculateAverageRating($productId)
    {
        return ProductReview::where('product_id', $productId)
            ->avg('rating') ?? 0;
    }
}
