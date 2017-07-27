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

    protected $events = [
        'created' => \App\Events\BandCreated::class,
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class)->orderBy('published_at');
    }

    public function getSlugAttribute()
    {
        return str_slug($this->name, '-');
    }

    public function getPermalinkAttribute()
    {
        return route('showBand', [$this->slug, $this->id]);
    }
}
