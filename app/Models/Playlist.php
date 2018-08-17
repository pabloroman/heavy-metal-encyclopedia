<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Playlist extends Model
{
    use CrudTrait;

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'id',
        'title',
        'description',
        'image',
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
