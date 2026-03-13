<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Clarifi;
use Illuminate\Http\Request;

class ClarifiController extends Controller
{
    // Display a listing of all clarifies.
    public function GetClarifies()
    {
        $clarifies = Clarifi::latest()->get();
        return view('admin.backend.clarifies.get_clarifies', compact('clarifies'));
    }
}
