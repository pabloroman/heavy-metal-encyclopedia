<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Band;

class BandController extends Controller
{
    public function show($slug, Band $band)
    {
        return view('bands.show', compact('band'));
    }
}
