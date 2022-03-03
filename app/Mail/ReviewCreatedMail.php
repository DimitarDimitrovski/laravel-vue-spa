<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var int
     */
    public $reviewId;
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
     * @param int $reviewId
     * @param string $author
     * @param string $admin
     */
    public function __construct(int $reviewId, string $author, string $admin)
    {
        $this->reviewId = $reviewId;
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
        return $this->markdown('emails.review.created');
    }
}
