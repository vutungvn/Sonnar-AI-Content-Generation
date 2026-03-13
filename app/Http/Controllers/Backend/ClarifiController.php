<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Clarifi;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ClarifiController extends Controller
{
    // Display a listing of all clarifies.
    public function GetClarifies()
    {
        $clarifies = Clarifi::latest()->get();
        return view('admin.backend.clarifies.get_clarifies', compact('clarifies'));
    }

    // Show the form for creating a new clarify.
    public function AddClarify()
    {
        return view('admin.backend.clarifies.add_clarify');
    }

    // Store new clarify in the database.
    public function StoreClarify(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(302, 618)->save(public_path('upload/clarify/' . $name_gen));
            $save_url = 'upload/clarify/' . $name_gen;

            Clarifi::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $save_url,
            ]);
        } else {
            Clarifi::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }

        $notification = array(
            'message' => 'Clarify added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.clarifies')->with($notification);
    }
}
