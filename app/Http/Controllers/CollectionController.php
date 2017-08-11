<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;

class CollectionController extends Controller
{
    public function show(Playlist $playlist)
    {
        return view('collections.show', compact('playlist'));
    }
}
