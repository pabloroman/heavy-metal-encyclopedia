<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'id',
        'title',
        'body',
        'featured_image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }
}
