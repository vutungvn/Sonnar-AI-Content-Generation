<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    // Display a listing of all features.
    public function AllFeature()
    {
        $features = Feature::latest()->get();
        return view('admin.backend.features.all_features', compact('features'));
    }

    // Add a new feature.
    public function AddFeature()
    {
        return view('admin.backend.features.add_feature');
    }

    // Store new feature in the database.
    public function StoreFeature(Request $request)
    {
        Feature::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
        ]);

        $notification = array(
            'message' => 'Feature added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.feature')->with($notification);
    }
}
