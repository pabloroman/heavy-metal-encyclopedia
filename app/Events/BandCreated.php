<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Services\MetalArchives;
use App\Models\Album;
use App\Jobs\UploadImage;

class BandCreated
{
    use Dispatchable, SerializesModels;

    public $band;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($band)
    {
        $bandInfo = (new MetalArchives())->getBand($band->original_permalink);
        $band->fill($bandInfo);
        $band->save();

        dispatch(new UploadImage($band));

        $bandDiscography = (new MetalArchives())->getBandDiscography($band->id);

        foreach ($bandDiscography as $albumInfo) {
            $album = Album::firstOrCreate(['id' => $albumInfo['id']], ['permalink' => $albumInfo['permalink']]);
            if (!$album->bands->contains($band->id)) {
                $album->bands()->attach($band->id);
            }
        }
    }
}
