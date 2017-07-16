<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    public $incrementing = false;
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'id',
        'permalink',
        'name',
        'logo',
        'image',
        'country',
        'status',
        'genre',
        'lyrical_themes',
        'founded_at',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }
}
