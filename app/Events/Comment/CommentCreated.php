<?php

namespace App\Events\Comment;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $commentId;

    /**
     * Create a new event instance.
     *
     * @param $commentId
     */
    public function __construct(int $commentId)
    {
        $this->commentId = $commentId;
    }
}
