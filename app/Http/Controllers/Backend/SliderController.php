<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    // Display a listing of all sliders.
    public function GetSliders()
    {
        $sliders = Slider::latest()->get();
        return view('admin.backend.sliders.get_sliders', compact('sliders'));
    }
}
