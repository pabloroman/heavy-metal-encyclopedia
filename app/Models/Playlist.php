<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'id',
        'title',
        'description',
        'image',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }
}
