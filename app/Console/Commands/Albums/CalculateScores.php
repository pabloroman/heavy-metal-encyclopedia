<?php

namespace App\Console\Commands\Albums;

use Illuminate\Console\Command;
use App\Models\Album;

class CalculateScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'albums:calculate-scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store scores from albums';

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
        $bar = $this->output->createProgressBar(Album::count());

        Album::with('reviews')->chunk(100, function ($albums) use ($bar) {
            foreach ($albums as $album) {
                $album->average_score = $album->getAverageScore();
                $album->median_score = $album->getMedianScore();
                $album->review_count = $album->getReviewCount();
                $album->save();
                $bar->advance();
            }
        });
        $bar->finish();
    }
}
