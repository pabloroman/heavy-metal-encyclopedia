<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Services\MetalArchives;
use App\Jobs\UploadImage;

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
        if ($albumInfo['image_original_url']) {
            dispatch(new UploadImage($albumInfo['image_original_url'], 'albums'));
            $albumInfo['image_url'] = 'https://s3.amazonaws.com/assets.heavymetalencyclopedia.com/albums' . parse_url($this->url)['path'];
        }

        $album->fill($albumInfo);
        $album->save();
    }
}
