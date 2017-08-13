<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Services\MetalArchives;

class ReviewCreated
{
    use Dispatchable, SerializesModels;

    public $review;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($review)
    {
        $reviewInfo = (new MetalArchives())->getReview($review->album_id, $review_id);
        $review->fill($reviewInfo);
        $review->save();
    }
}
