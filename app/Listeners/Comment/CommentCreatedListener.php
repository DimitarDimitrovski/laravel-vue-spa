<?php

namespace App\Listeners\Comment;

use App\DAL\Comment\CommentRepository;
use App\Events\Comment\CommentCreated;
use App\Mail\CommentCreatedMail;
use Illuminate\Support\Facades\Mail;

class CommentCreatedListener
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
     * @param  CommentCreated  $event
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        $comment = $this->commentRepository->findWithRelations($event->commentId, ['User']);
        $author = $comment->User->name;

        foreach (config('mail.recipients.admins') as $admin) {
            Mail::to($admin->email)->send(new CommentCreatedMail($event->commentId, $author, $admin->name));
        }
    }
}
