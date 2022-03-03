<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Model
     */
    public $comment;
    /**
     * @var string
     */
    public $admin;
    /**
     * @var string
     */
    public $message;

    /**
     * Create a new message instance.
     *
     * @param Model $comment
     * @param string $admin
     * @param string $message
     */
    public function __construct(Model $comment, string $admin, string $message)
    {
        $this->comment = $comment;
        $this->admin = $admin;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.comment.approval');
    }
}
