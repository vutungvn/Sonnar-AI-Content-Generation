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
}
