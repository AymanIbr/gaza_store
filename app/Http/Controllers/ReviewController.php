<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Validate the input
        $request->validate([
            'product_rating' => 'required|integer|min:1|max:5',
        ], [
            'product_rating.required' => 'Please select a rating.',
            'product_rating.integer' => 'Rating must be an integer.',
            'product_rating.min' => 'Minimum rating is 1 star.',
            'product_rating.max' => 'Maximum rating is 5 stars.',
        ]);

        $ip = $request->ip();

        // $hasPurchased = Order::where('ip_address', $ip)
        //     ->whereHas('orderItems', function ($query) use ($product) {
        //         $query->where('product_id', $product->id);
        //     })
        //     ->exists();

        // if (!$hasPurchased) {
        //     return response()->json([
        //         'message' => 'You can only rate products you have purchased.'
        //     ], 403);
        // }

        // Check if this IP already rated this product
        $alreadyRated = Review::where('product_id', $product->id)
            ->where('ip_address', $ip)
            ->exists();

        if ($alreadyRated) {
            // session()->flash('error', 'You have already rated this product.');
            // return redirect()->back();
            return response()->json([
                'message' => 'You have already rated this product.'
            ], 422);
        }

        // Create the review
        Review::create([
            'product_id' => $product->id,
            'ip_address' => $ip,
            'stars_rated' => $request->input('product_rating'),
        ]);

        return response()->json([
            'message' => 'Your rating has been submitted successfully. Thank you!'
        ], 200);
    }
}
