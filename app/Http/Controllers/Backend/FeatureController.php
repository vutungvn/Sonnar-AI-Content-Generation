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

    // Edit an existing feature.
    public function EditFeature($id)
    {
        $feature = Feature::find($id);
        return view('admin.backend.features.edit_feature', compact('feature'));
    }

    // Update an existing feature in the database.
    public function UpdateFeature(Request $request)
    {
        $id = $request->id;

        Feature::find($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
        ]);

        $notification = array(
            'message' => 'Feature updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.feature')->with($notification);
    }

    // Delete a feature from the database.
    public function DeleteFeature($id)
    {
        Feature::find($id)->delete();

        $notification = array(
            'message' => 'Feature deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
