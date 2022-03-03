<?php

namespace App\Http\Controllers\Api;

use App\DAL\Comment\CommentRepository;
use App\Events\Comment\CommentCreated;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentApiController extends BaseApiController
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        parent::__construct();
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request): JsonResponse {
        $params = $request->only(['user_id', 'parent_id', 'content']);
        $comment = $this->commentRepository->create($params);
        event(new CommentCreated($comment->id));

        return response()->json(
            ['message' => 'Your comment was created successfully. Please wait while admin reviews it for approval.'], 200
        );
    }

    public function latestComments(): ResourceCollection
    {
        return CommentResource::collection($this->commentRepository->latest());
    }
}
