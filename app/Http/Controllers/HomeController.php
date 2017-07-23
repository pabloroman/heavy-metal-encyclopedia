<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Band;
use App\Models\Album;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $bandCount = Band::count();
        $albumCount = Album::count();
        $reviewCount = Review::count();
        $trendingAlbums = Album::getTrending();

        return view('home.index', compact('bandCount', 'albumCount', 'reviewCount', 'trendingAlbums'));
    }
}
