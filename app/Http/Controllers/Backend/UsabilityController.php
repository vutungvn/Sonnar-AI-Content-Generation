<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Usability;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UsabilityController extends Controller
{
    // Display a listing of all usabilities.
    public function GetUsabilities()
    {
        $usabilities = Usability::latest()->get();
        return view('admin.backend.usabilities.get_usabilities', compact('usabilities'));
    }

    // Show the form for creating a new usability.
    public function AddUsability()
    {
        return view('admin.backend.usabilities.add_usability');
    }

    // Store new usability in the database.
    public function StoreUsability(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(560, 400)->save(public_path('upload/usability/' . $name_gen));
            $save_url = 'upload/usability/' . $name_gen;

            Usability::create([
                'title' => $request->title,
                'description' => $request->description,
                'youtube' => $request->youtube,
                'link' => $request->link,
                'image' => $save_url,
            ]);
        } else {
            Usability::create([
                'title' => $request->title,
                'description' => $request->description,
                'youtube' => $request->youtube,
                'link' => $request->link,
            ]);
        }

        $notification = array(
            'message' => 'Usability added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.usabilities')->with($notification);
    }

    // Edit an existing usability.
    public function EditUsability($id)
    {
        $usability = Usability::find($id);
        return view('admin.backend.usabilities.edit_usability', compact('usability'));
    }

    // Update an existing usability in the database.
    public function UpdateUsability(Request $request)
    {
        $usability = Usability::findOrFail($request->id);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'youtube' => $request->youtube,
            'link' => $request->link,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(560, 400)->save(public_path('upload/usability/' . $name_gen));

            $data['image'] = 'upload/usability/' . $name_gen;

            $oldImagePath = $usability->image ? public_path($usability->image) : null;
            if ($oldImagePath && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $usability->update($data);

        $notification = array(
            'message' => $request->hasFile('image')
                ? 'Usability updated with image successfully'
                : 'Usability updated without image successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.usabilities')->with($notification);
    }
}
