<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Band;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $bands = Band::where('name', $query)->get();
        if ($bands->count() == 1) {
            return redirect()->route('showBand', [$bands->first()->slug, $bands->first()->id]);
        } else {
            if ($bands->count() > 1) {
                $albums = Album::where('title', $query)->get();
                return view('search.results', compact('bands', 'albums'));
            } else {
                $albums = Album::where('title', $query)->get();
                if ($albums->count() == 1) {
                    return redirect()->route('showAlbum', [$albums->first()->slug, $albums->first()->id]);
                } else {
                    return view('search.results', compact('bands', 'albums'));
                }
            }
        }
    }
}
