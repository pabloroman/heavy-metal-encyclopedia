<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BandDeleted
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
        if ($band->albums->count()) {
            $band->albums->each(function ($album) {
                $album->delete();
            });
        }
    }
}
