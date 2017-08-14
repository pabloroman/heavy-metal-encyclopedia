<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'name',
        'role',
        'album_id',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
