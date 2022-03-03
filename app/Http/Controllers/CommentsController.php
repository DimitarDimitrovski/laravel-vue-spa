<?php

namespace App\Http\Controllers;

use App\DAL\Comment\CommentRepository;
use App\Events\Comment\CommentApproval;
use App\Http\Requests\ApprovalRequest;

class CommentsController extends BaseController
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $comments = $this->commentRepository->all(['*'], ['User', 'Recipe']);
        $deletedComments = $this->commentRepository->newQuery()->onlyTrashed()->get()
            ->load([
                'User' => function($query) { $query->withTrashed(); },
                'Recipe' => function($query) { $query->withTrashed(); }
            ]);
        $data = compact('comments', 'deletedComments');

        return view('admin.comments.index', $data);
    }

    public function show($id)
    {
        $comment = $this->commentRepository->findWithRelations($id, ['User']);
        $data = compact('comment');

        return view('admin.comments.show', $data);
    }

    public function destroy($id)
    {
        $comment = $this->commentRepository->findWithRelations($id, ['Replies']);

        if($comment->Replies) {
            $this->deleteComments($comment->Replies);
        }

        $comment->delete();

        return response()->json(['status' => 'success', 'message' => 'Comment was deleted successfully']);
    }

    public function approval($id, ApprovalRequest $request)
    {
        $comment = $this->commentRepository->findOrFail($id);
        $params = $request->only(['approved']);
        $comment->update($params);
        event(new CommentApproval($comment->id, auth()->user()->name, $request->get('message')));

        return redirect()->back()->with(['message' => 'Recipe approval status was set successfully']);
    }
}
