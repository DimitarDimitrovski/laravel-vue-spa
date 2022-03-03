<?php

namespace App\Listeners\Review;

use App\DAL\Review\ReviewRepository;
use App\Events\Review\ReviewApproval;
use App\Mail\ReviewApprovalMail;
use Illuminate\Support\Facades\Mail;

class ReviewApprovalListener
{
    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

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
     * @param  ReviewApproval  $event
     * @return void
     */
    public function handle(ReviewApproval $event)
    {
        $review = $this->reviewRepository->findWithRelations($event->reviewId, ['Recipe', 'User']);
        Mail::to($review->User->email)->send(new ReviewApprovalMail($review, $event->admin, $event->message));
    }
}
