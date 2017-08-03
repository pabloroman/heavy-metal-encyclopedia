<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;
use GuzzleHttp\Client as GuzzleClient;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $url;
    public $prefix;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $prefix)
    {
        $this->url = $url;
        $this->prefix = $prefix;
    }

    public function handle()
    {
        $path = $this->prefix . parse_url($this->url)['path'];

        file_put_contents('/tmp/image', file_get_contents($this->url));
        $resource = fopen('/tmp/image', 'r');
        Storage::disk('s3')->put($path, $resource);
    }
}
