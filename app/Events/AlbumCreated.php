<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Services\MetalArchives;

class AlbumCreated
{
    use Dispatchable, SerializesModels;

    public $review;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($album)
    {
        $albumInfo = (new MetalArchives())->getAlbum($album->permalink);
        $album->fill($albumInfo);
        $album->save();
    }
}
