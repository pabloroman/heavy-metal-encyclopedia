<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Album extends Model
{
    public $incrementing = false;
    protected $dates = ['created_at', 'updated_at', 'published_at'];

    protected $fillable = [
        'id',
        'permalink',
        'published_at',
        'title',
        'image',
        'type',
        'label',
        'average_score',
        'median_score',
        'review_count',
    ];

    protected $events = [
        'created' => \App\Events\AlbumCreated::class,
    ];

    public function bands()
    {
        return $this->belongsToMany(Band::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getSlugAttribute()
    {
        return str_slug($this->title, '-');
    }

    public function getPermalinkAttribute()
    {
        return route('showAlbum', [$this->slug, $this->id]);
    }

    public function getBandNameAttribute()
    {
        return implode('/', $this->bands->pluck('name')->toArray());
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

    public static function getTrending()
    {
        return self::where('published_at', '>=', Carbon::now()->subMonths(6))->orderBy('review_count', 'desc')->take(12)->get();
    }
}
