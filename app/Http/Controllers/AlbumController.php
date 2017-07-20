<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
    public function show($slug, Album $album)
    {
        return view('albums.show', compact('album'));
    }
}
