<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Song;
use App\Models\Lineup;
use App\Services\MetalArchives;

class AddSongsAndLineup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $album;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($album)
    {
        $this->album = $album;
    }

    public function handle()
    {
        $album = $this->album;
        $albumInfo = (new MetalArchives())->getAlbum($album->id);

        if (isset($albumInfo['songs']) && !$album->songs->count()) {
            foreach ($albumInfo['songs'] as $song) {
                Song::create(array_merge($song, ['album_id' => $album->id]));
            }
        }

        if (isset($albumInfo['lineup']) && !$album->lineup->count()) {
            foreach ($albumInfo['lineup'] as $lineupItem) {
                Lineup::create(array_merge($lineupItem, ['album_id' => $album->id]));
            }
        }
    }
}
