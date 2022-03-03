<?php

namespace App\Events\Review;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewApproval
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reviewId;
    public $admin;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param $reviewId
     * @param $admin
     * @param $message
     */
    public function __construct(int $reviewId, string $admin, string $message)
    {
        $this->reviewId = $reviewId;
        $this->admin = $admin;
        $this->message = $message;
    }
}
