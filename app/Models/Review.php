<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\CrudTrait;

class Review extends Model
{
    use CrudTrait;
    use SoftDeletes;

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

    protected $events = [
        'created' => \App\Events\ReviewCreated::class,
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
