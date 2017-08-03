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

    public $model;
    public $image_url;
    public $image_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
        $this->image_url = $this->model->image_url_original;
        $this->image_path = $this->model->getTable() . parse_url($this->image_url)['path'];
    }

    public function handle()
    {
        if ($this->image_url) {
            $image = @file_get_contents($this->image_url);
            if ($image === false) {
                return false;
            }
            file_put_contents('/tmp/image', $image);

            if (Storage::disk('s3')->put($this->image_path, fopen('/tmp/image', 'r'))) {
                $this->model->image_url = 'https://s3.amazonaws.com/assets.heavymetalencyclopedia.com/' . $this->image_path;
                $this->model->save();
            }
        }
    }
}
