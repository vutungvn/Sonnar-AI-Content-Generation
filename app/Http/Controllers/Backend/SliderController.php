<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Title;
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
        } else {
            Slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
            ]);
        }

        $notification = array(
            'message' => 'Slider added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.slider')->with($notification);
    }

    // Edit an existing slider.
    public function EditSlider($id)
    {
        $slider = Slider::find($id);
        return view('admin.backend.sliders.edit_slider', compact('slider'));
    }

    // Update an existing slider in the database.
    public function UpdateSlider(Request $request)
    {
        $id = $request->id;
        $slider = Slider::find($id);
        $full_path = public_path($slider->image);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(306, 618)->save(public_path('upload/slider/' . $name_gen));
            $save_url = 'upload/slider/' . $name_gen;

            if (file_exists($full_path)) {
                unlink($full_path);
            }

            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Slider updated with image successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('get.slider')->with($notification);
        } else {
            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
            ]);

            $notification = array(
                'message' => 'Slider updated without image successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('get.slider')->with($notification);
        }
    }

    // Delete a slider from the database.
    public function DeleteSlider($id)
    {
        $slider = Slider::find($id);
        $image = $slider->image;
        if ($image) {
            unlink($image);
        }

        Slider::find($id)->delete();

        $notification = array(
            'message' => 'Slider deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // Edit slider
    public function EditSliderWithTitleAndDescription(Request $request, $id)
    {
        $slider = Slider::find($id);

        if ($request->has('title')) {
            $slider->title = $request->title;
        }

        if ($request->has('description')) {
            $slider->description = $request->description;
        }

        $slider->save();

        return response()->json(['success' => true]);
    }

    // Edit Features
    public function EditFeatures(Request $request, $id)
    {
        $title = Title::find($id);

        if ($request->has('features')) {
            $title->features = $request->features;
        }

        $title->save();

        return response()->json(['success' => true]);
    }
}
