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

    // Edit an existing clarify.
    public function EditClarify($id)
    {
        $clarify = Clarifi::find($id);
        return view('admin.backend.clarifies.edit_clarify', compact('clarify'));
    }

    // Update an existing clarify in the database.
    public function UpdateClarify(Request $request)
    {
        $clarify = Clarifi::findOrFail($request->id);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(302, 618)->save(public_path('upload/clarify/' . $name_gen));

            $data['image'] = 'upload/clarify/' . $name_gen;

            $oldImagePath = $clarify->image ? public_path($clarify->image) : null;
            if ($oldImagePath && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $clarify->update($data);

        $notification = array(
            'message' => $request->hasFile('image')
                ? 'Clarify updated with image successfully'
                : 'Clarify updated without image successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('get.clarifies')->with($notification);
    }

    // Delete a clarify from the database.
    public function DeleteClarify($id)
    {
        $clarify = Clarifi::find($id);
        $image = $clarify->image;
        if ($image) {
            unlink($image);
        }

        Clarifi::find($id)->delete();

        $notification = array(
            'message' => 'Clarify deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
