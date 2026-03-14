<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Usability;
use Illuminate\Http\Request;

class UsabilityController extends Controller
{
    // Display a listing of all usabilities.
    public function GetUsabilities()
    {
        $usabilities = Usability::latest()->get();
        return view('admin.backend.usabilities.get_usabilities', compact('usabilities'));
    }
}
