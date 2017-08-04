<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AlbumDeleted
{
    use Dispatchable, SerializesModels;

    public $album;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($album)
    {
        if ($album->reviews->count()) {
            $album->reviews->each(function ($review) {
                $review->delete();
            });
        }
    }
}
