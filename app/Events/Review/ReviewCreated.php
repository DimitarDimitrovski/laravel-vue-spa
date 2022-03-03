<?php

namespace App\Events\Review;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $reviewId;

    /**
     * Create a new event instance.
     *
     * @param int $reviewId
     */
    public function __construct(int $reviewId)
    {
        $this->reviewId = $reviewId;
    }
}
