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
        $bandInfo = (new MetalArchives())->getBand($band->permalink);
        if ($bandInfo['image_original_url']) {
            dispatch(new UploadImage($bandInfo['image_original_url'], 'bands'));
            $bandInfo['image_url'] = 'https://s3.amazonaws.com/assets.heavymetalencyclopedia.com/bands' . parse_url($this->url)['path'];
        }

        $band->fill($bandInfo);
        $band->save();

        $bandDiscography = (new MetalArchives())->getBandDiscography($band->id);

        foreach ($bandDiscography as $albumInfo) {
            $album = Album::firstOrCreate(['id' => $albumInfo['id']], ['permalink' => $albumInfo['permalink']]);
            if (!$album->bands->contains($band->id)) {
                $album->bands()->attach($band->id);
            }
        }
    }
}
