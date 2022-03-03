<?php

namespace App\Events\Comment;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentApproval
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $commentId;
    /**
     * @var string
     */
    public $admin;
    /**
     * @var string
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param int $commentId
     * @param string $admin
     * @param string $message
     */
    public function __construct(int $commentId, string $admin, string $message)
    {
        $this->commentId = $commentId;
        $this->admin = $admin;
        $this->message = $message;
    }
}
