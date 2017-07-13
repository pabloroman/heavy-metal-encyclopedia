<?php

namespace App\Console\Commands\MetalArchives;

use Illuminate\Console\Command;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use App\Jobs\CreateReview;
use App\Helpers\Parser;

class Importer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metal-archives:importer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from metal-archives.com';

    public $counter;

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
        $startDate = new Carbon('2002-07');
        $endDate = Carbon::now();
        $pointer = $startDate;

        do {
            $this->counter = 0;
            echo $pointer->format('Y-m').PHP_EOL;
            $this->fetchReviewsByDate($pointer->format('Y'), $pointer->format('m'));
            $pointer = $pointer->addMonth(1);
        } while ($pointer <= $endDate);
    }

    private function fetchReviewsByDate($year, $month, $starts_at = 0)
    {
        $client = new GuzzleClient(['base_uri' => 'https://www.metal-archives.com']);

        $url = '/review/ajax-list-browse/by/date/selection/' . $year . '-' . $month . '/json/1?';
        $query = http_build_query([
            'sEcho' => 1,
            'iDisplayStart' => $starts_at,
            'iDisplayLength' => 200,
            'sSortDir_0' => 'asc',
        ]);

        echo $url . $query . PHP_EOL;

        $response = $client->get($url . $query);
        $reviews = [];

        if (200 === $response->getStatusCode()) {
            $results = json_decode((string) $response->getBody());
            $total = $results->iTotalRecords;
            echo "Total records: ". $total.PHP_EOL;
            $data = $results->aaData;
            foreach ($data as $review) {
                $job = $this->parseReviewData($review);
                $job['published_at'] = new Carbon($job['published_at'] . ' ' . $year);
                dispatch(new CreateReview($job));
            }
        } else {
            echo $response->getStatusCode();
            exit;
        }

        if ($this->counter < $total) {
            $this->counter = 200 + $starts_at;
            echo $this->counter.PHP_EOL;
            $this->fetchReviewsByDate($year, $month, 200 + $starts_at);
        }
    }

    private function parseReviewData($data)
    {
        $date = $data[0];
        $review = Parser::parseLink($data[1]);
        $album = Parser::parseLink($data[3]);
        $score = Parser::parseScore($data[4]);
        $author = Parser::parseLink($data[5]);

        return [
            'published_at' => $date,
            'permalink' => $review['permalink'],
            'album_id' => $album['id'],
            'album_permalink' => $album['permalink'],
            'score' => $score,
            'author' => $author['id'],
            'author_id' => $review['id'],
        ];
    }
}
