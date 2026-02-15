<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

    // Store new review in the database.
    public function StoreReview(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(60, 60)->save(public_path('upload/review/' . $name_gen));
            $save_url = 'upload/review/' . $name_gen;

            Review::create([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $save_url,
                'message' => $request->message,
            ]);
        }

        $notification = array(
            'message' => 'Review added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.review')->with($notification);
    }

    // Edit an existing review.
    public function EditReview($id)
    {
        $review = Review::find($id);
        return view('admin.backend.reviews.edit_review', compact('review'));
    }

    // Update an existing review in the database.
    public function UpdateReview(Request $request)
    {
        $id = $request->id;
        $review = Review::find($id);
        $oldPhotoPath = $review->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(60, 60)->save(public_path('upload/review/' . $name_gen));
            $save_url = 'upload/review/' . $name_gen;

            if ($oldPhotoPath && $oldPhotoPath !== $save_url) {
                $this->deleteOldPhoto($oldPhotoPath);
            }

            Review::find($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $save_url,
                'message' => $request->message,
            ]);

            $notification = array(
                'message' => 'Review updated with image successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.review')->with($notification);
        } else {
            Review::find($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
            ]);

            $notification = array(
                'message' => 'Review updated without image successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.review')->with($notification);
        }
    }

    private function deleteOldPhoto(string $oldPhotoPath)
    {
        $fullPath = public_path($oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
