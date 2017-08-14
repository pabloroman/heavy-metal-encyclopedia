<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Services\MetalArchives;
use App\Jobs\UploadImage;
use App\Models\Song;
use App\Models\Lineup;

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
        $albumInfo = (new MetalArchives())->getAlbum($album->id);
        if ($albumInfo == 404) {
            $album->delete();
        } else {
            $album->fill($albumInfo);
            $album->save();

            if (isset($albumInfo['songs'])) {
                foreach ($albumInfo['songs'] as $song) {
                    Song::create(array_merge($song, ['album_id' => $album->id]));
                }
            }

            if (isset($albumInfo['lineup'])) {
                foreach ($albumInfo['lineup'] as $lineupItem) {
                    Lineup::create(array_merge($lineupItem, ['album_id' => $album->id]));
                }
            }

            dispatch(new UploadImage($album));
        }
    }
}
