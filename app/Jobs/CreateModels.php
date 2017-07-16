<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Review;
use App\Models\Album;
use App\Models\Band;

class CreateModels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reviewData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reviewData)
    {
        $this->reviewData = $reviewData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->reviewData['album_id'] || !$this->reviewData['bands'][0]['id']) {
            return;
        }

        $album = Album::firstOrCreate(['id' => $this->reviewData['album_id']], ['permalink' => $this->reviewData['album_permalink']]);
        Review::firstOrCreate(['album_id' => $this->reviewData['album_id'], 'author_id' => $this->reviewData['author_id']], $this->reviewData);

        $bands = $this->reviewData['bands'];
        foreach ($bands as $band) {
            $band = Band::firstOrCreate(['id' => $band['id']], ['permalink' => $band['permalink']]);
            if (!$album->bands->contains($band->id)) {
                $album->bands()->attach($band->id);
            }
        }
    }
}
