<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    // Display a listing of all sliders.
    public function GetSliders()
    {
        $sliders = Slider::latest()->get();
        return view('admin.backend.sliders.get_sliders', compact('sliders'));
    }

    // Show the form for creating a new slider.
    public function AddSlider()
    {
        return view('admin.backend.sliders.add_slider');
    }

    // Store new slider in the database.
    public function StoreSlider(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(306, 618)->save(public_path('upload/slider/' . $name_gen));
            $save_url = 'upload/slider/' . $name_gen;

            Slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Slider added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.slider')->with($notification);
    }
}
