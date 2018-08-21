<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show()
    {
        $article = new Article();
        $article->featured_image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ee/Isis_ensemble.jpg/1920px-Isis_ensemble.jpg';
        return view('articles.show', compact('article'));
    }
}
