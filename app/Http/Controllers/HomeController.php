<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Band;
use App\Models\Album;
use App\Models\Review;
use App\Models\Playlist;

class HomeController extends Controller
{
    public function index()
    {
        $bandCount = Band::count();
        $albumCount = Album::count();
        $reviewCount = Review::count();

        $playlists = Playlist::take(5)->get();

        return view('home.index', compact('bandCount', 'albumCount', 'reviewCount', 'playlists'));
    }
}
