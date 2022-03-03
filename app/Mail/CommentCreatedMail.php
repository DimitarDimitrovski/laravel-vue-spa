<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var int
     */
    public $commentId;
    /**
     * @var string
     */
    public $author;
    /**
     * @var string
     */
    public $admin;

    /**
     * Create a new message instance.
     *
     * @param int $commentId
     * @param string $author
     * @param string $admin
     */
    public function __construct(int $commentId, string $author, string $admin)
    {
        $this->commentId = $commentId;
        $this->author = $author;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.comment.created');
    }
}
