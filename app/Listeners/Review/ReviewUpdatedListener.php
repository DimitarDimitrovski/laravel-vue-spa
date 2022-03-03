<?php

namespace App\Listeners\Review;

use App\DAL\Review\ReviewRepository;
use App\Events\Review\ReviewUpdated;
use App\Mail\ReviewUpdatedMail;
use Illuminate\Support\Facades\Mail;

class ReviewUpdatedListener
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
     * @param  ReviewUpdated  $event
     * @return void
     */
    public function handle(ReviewUpdated $event)
    {
        $review = $this->reviewRepository->findWithRelations($event->reviewId, ['User']);
        $author = $review->User->name;

        foreach (config('mail.recipients.admins') as $admin) {
            Mail::to($admin->email)->send(new ReviewUpdatedMail($event->reviewId, $author, $admin->name));
        }
    }
}
