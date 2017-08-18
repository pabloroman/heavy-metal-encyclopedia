<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Album;

class UpdateAlbumScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $album;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    public function handle()
    {
        $album = $this->album;
        $album->average_score = $album->getAverageScore();
        $album->median_score = $album->getMedianScore();
        $album->review_count = $album->getReviewCount();
        $album->save();
    }
}
