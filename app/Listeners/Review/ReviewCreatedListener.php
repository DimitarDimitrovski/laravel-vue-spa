<?php

namespace App\Listeners\Review;

use App\DAL\Review\ReviewRepository;
use App\Events\Review\ReviewCreated;
use App\Mail\ReviewCreatedMail;
use Illuminate\Support\Facades\Mail;

class ReviewCreatedListener
{
    /**
     * @var ReviewRepository
     */
    public $reviewRepository;

    /**
     * Create the event listener.
     *
     * @param ReviewRepository $reviewRepository
     */
    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ReviewCreated  $event
     * @return void
     */
    public function handle(ReviewCreated $event)
    {
        $review = $this->reviewRepository->findWithRelations($event->reviewId, ['User']);
        $author = $review->User->name;

        foreach (config('mail.recipients.admins') as $admin) {
            Mail::to($admin->email)->send(new ReviewCreatedMail($event->reviewId, $author, $admin->name));
        }
    }
}
