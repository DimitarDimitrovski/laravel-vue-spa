<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Model
     */
    public $review;
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
     * @param Model $review
     * @param string $admin
     * @param string $message
     */
    public function __construct(Model $review, string $admin, string $message)
    {
        $this->review = $review;
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
        return $this->markdown('emails.review.approval');
    }
}
