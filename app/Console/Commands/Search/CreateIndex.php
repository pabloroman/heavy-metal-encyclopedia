<?php

namespace App\Console\Commands\Search;

use Illuminate\Console\Command;
use App\Models\Album;
use App\Models\Band;
use Elasticsearch;

class CreateIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:create-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create elasticsearch index';

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
        $this->initIndex();
        $this->indexBands();
        $this->indexAlbums();
    }

    private function initIndex()
    {
        $index = 'hme';

        if (!Elasticsearch::indices()->exists(['index' => $index])) {
            Elasticsearch::indices()->create(['index' => $index]);
        }

        $bandsMapping = $this->createBandsMapping($index);
        ElasticSearch::indices()->putMapping($bandsMapping);

        $albumsMapping = $this->createAlbumsMapping($index);
        ElasticSearch::indices()->putMapping($albumsMapping);
    }

    private function createBandsMapping($index)
    {
        $params['index'] = $index;
        $params['type'] = 'bands';
        $params['body']['bands'] = [
            '_source' => [
                'enabled' => true,
            ],
            '_all' => [
                'enabled' => false,
            ],
            'properties' => [
                'id' => [
                    'type' => 'integer',
                ],
                'name' => [
                    'type' => 'text',
                ],
                'genre' => [
                    'type' => 'text',
                ],
                'country' => [
                    'type' => 'keyword',
                ],
                'lyrical_themes' => [
                    'type' => 'text',
                ],
            ]
        ];

        return $params;
    }

    private function indexBands()
    {
        $bar = $this->output->createProgressBar(Band::count());
        Band::chunk(100, function ($bands) use ($bar) {
            foreach ($bands as $band) {
                $params = [
                    'index' => 'hme',
                    'type' => 'bands',
                    'id' => $band->id,
                    'body' => [
                        'name' => $band->name,
                        'genre' => array_map('trim', explode(',', $band->genre)),
                        'country' => $band->country,
                        'lyrical_themes' => array_map('trim', explode(',', $band->lyrical_themes)),
                    ],
                ];
                $response = Elasticsearch::index($params);
                $bar->advance();
            }
        });
        $bar->finish();
    }

    private function createAlbumsMapping($index)
    {
        $params['index'] = $index;
        $params['type'] = 'albums';
        $params['body']['albums'] = [
            '_source' => [
                'enabled' => true,
            ],
            '_all' => [
                'enabled' => false,
            ],
            'properties' => [
                'id' => [
                    'type' => 'integer',
                ],
                'title' => [
                    'type' => 'text',
                ],
                'label' => [
                    'type' => 'keyword',
                ],
                'review_count' => [
                    'type' => 'integer',
                ],
                'median_score' => [
                    'type' => 'float',
                ]
            ]
        ];

        return $params;
    }

    private function indexAlbums()
    {
        $bar = $this->output->createProgressBar(Album::count());
        Album::chunk(100, function ($albums) use ($bar) {
            foreach ($albums as $album) {
                $params = [
                    'index' => 'hme',
                    'type' => 'albums',
                    'id' => $album->id,
                    'body' => [
                        'title' => $album->title,
                        'label' => $album->label,
                        'review_count' => $album->review_count,
                        'median_score' => $album->median_score,
                    ],
                ];
                $response = Elasticsearch::index($params);
                $bar->advance();
            }
        });
        $bar->finish();
    }
}
