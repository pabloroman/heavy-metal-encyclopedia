<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\CrudTrait;

class Band extends Model
{
    use SoftDeletes;
    use CrudTrait;

    public $incrementing = false;
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'id',
        'permalink',
        'name',
        'logo',
        'image_url',
        'image_url_original',
        'country',
        'status',
        'genre',
        'lyrical_themes',
        'founded_at',
        'review_count',
    ];

    protected $events = [
        'created' => \App\Events\BandCreated::class,
        'deleted' => \App\Events\BandDeleted::class,
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class)->orderBy('published_at', 'desc');
    }

    public function getSlugAttribute()
    {
        return str_slug($this->name, '-');
    }

    public function getOriginalPermalinkAttribute()
    {
        return $this->attributes['permalink'];
    }

    public function getPermalinkAttribute()
    {
        return route('showBand', [$this->slug, $this->id]);
    }

    public function getImageAttribute()
    {
        return $this->image_url ?? $this->image_url_original;
    }
}
