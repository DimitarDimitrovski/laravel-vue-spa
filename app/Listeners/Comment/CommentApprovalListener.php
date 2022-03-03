<?php

namespace App\Listeners\Comment;

use App\DAL\Comment\CommentRepository;
use App\Events\Comment\CommentApproval;
use App\Mail\CommentApprovalMail;
use Illuminate\Support\Facades\Mail;

class CommentApprovalListener
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * Create the event listener.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Handle the event.
     *
     * @param  CommentApproval  $event
     * @return void
     */
    public function handle(CommentApproval $event)
    {
        $comment = $this->commentRepository->findWithRelations($event->commentId, ['User']);
        Mail::to($comment->User->email)->send(new CommentApprovalMail($comment, $event->admin, $event->message));
    }
}
