<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $dates = ['created_at', 'updated_at', 'published_at'];

    protected $fillable = [
        'permalink',
        'published_at',
        'author',
        'score',
        'title',
        'body',
        'author_id',
        'album_id',
    ];
}
