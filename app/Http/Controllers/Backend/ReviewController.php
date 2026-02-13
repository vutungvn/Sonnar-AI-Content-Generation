<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Display a listing of all reviews.
    public function AllReview()
    {
        $reviews = Review::latest()->get();
        return view('admin.backend.reviews.all_reviews', compact('reviews'));
    }

    // Add a new review.
    public function AddReview()
    {
        return view('admin.backend.reviews.add_review');
    }
}
