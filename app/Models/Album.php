<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Album extends Model
{
    use SoftDeletes;

    public $incrementing = false;
    protected $dates = ['created_at', 'updated_at', 'published_at'];

    protected $fillable = [
        'id',
        'permalink',
        'published_at',
        'title',
        'image_url',
        'image_url_original',
        'type',
        'label',
        'average_score',
        'median_score',
        'review_count',
    ];

    protected $events = [
        'created' => \App\Events\AlbumCreated::class,
        'deleted' => \App\Events\AlbumDeleted::class,
    ];

    public function bands()
    {
        return $this->belongsToMany(Band::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->orderBy('published_at', 'desc');
    }

    public function lineup()
    {
        return $this->hasMany(Lineup::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class)->orderBy('disc', 'asc')->orderBy('order', 'asc');
    }

    public function getSlugAttribute()
    {
        return str_slug($this->title, '-');
    }

    public function getOriginalPermalinkAttribute()
    {
        return $this->attributes['permalink'];
    }

    public function getPermalinkAttribute()
    {
        return route('showAlbum', [$this->slug, $this->id]);
    }

    public function getBandDetailsAttribute()
    {
        return $this->bands->map(function ($band) {
            return ['name' => $band->name, 'permalink' => $band->getPermalinkAttribute()];
        });
    }

    public function getTypeSlugAttribute()
    {
        return str_slug($this->type);
    }

    public function getImageAttribute()
    {
        return $this->image_url ?? $this->image_url_original;
    }

    public function getYoutubeSearchLinkAttribute()
    {
        $query = urlencode(implode(' ', $this->bandDetails->pluck('name')->toArray()) . ' ' . $this->title);

        return "https://www.youtube.com/results?search_query=$query";
    }

    public function getReviewCount()
    {
        return $this->reviews->count();
    }

    public function getAverageScore()
    {
        return $this->getReviewCount() ? $this->reviews->sum('score')/$this->getReviewCount() : 0;
    }

    public function getMedianScore()
    {
        if ($this->getReviewCount()) {
            $scores = $this->reviews->pluck('score')->toArray();
            sort($scores);
            $count = count($scores);
            $middle = floor(($count-1)/2);
            if ($count % 2) {
                $median = $scores[$middle];
            } else {
                $low = $scores[$middle];
                $high = $scores[$middle+1];
                $median = (($low+$high)/2);
            }
            return $median;
        } else {
            return 0;
        }
    }

    public static function getTrending($take = 10)
    {
        return self::where('published_at', '>=', Carbon::now()->subMonths(6))->orderBy('review_count', 'desc')->take($take)->get();
    }
}
