<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Album;
use App\Models\Band;
use App\Models\Review;
use App\Models\Song;
use App\Models\Lineup;
use App\Services\MetalArchives;

class AdHoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metal-archives:adhoc {--action=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ad hoc commands';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->option('action');

        if (method_exists($this, $action)) {
            return $this->$action();
        }
    }

    public function fixEmptyAlbums()
    {
        $albums = Album::whereNull('title')->get();

        foreach ($albums as $brokenAlbum) {
            (new \App\Events\AlbumCreated($brokenAlbum));
        }
    }

    public function fixEmptyBands()
    {
        $bands = Band::whereNull('name')->get();

        foreach ($bands as $brokenBand) {
            (new \App\Events\BandCreated($brokenBand));
        }
    }

    public function fixEmptyReviews()
    {
        $reviews = Review::whereNull('title')->get();

        foreach ($reviews as $brokenReview) {
            (new \App\Events\ReviewCreated($brokenReview));
        }
    }

    public function addSongsAndLineup()
    {
        $bar = $this->output->createProgressBar(Album::count());
        Album::chunk(100, function ($albums) use ($bar) {
            foreach ($albums as $album) {
                $albumInfo = (new MetalArchives())->getAlbum($album->id);

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
            }
        });
        $bar->finish();
    }
}
