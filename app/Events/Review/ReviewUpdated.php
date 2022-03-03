<?php

namespace App\Events\Review;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reviewId;

    /**
     * Create a new event instance.
     *
     * @param $reviewId
     */
    public function __construct(int $reviewId)
    {
        $this->reviewId = $reviewId;
    }
}
