<?php


namespace App\DAL\Comment;

use App\DAL\EloquentRepositoryImpl;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class EloquentComment extends EloquentRepositoryImpl implements CommentRepository
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function latest(): Collection
    {
        return $this->newQuery()->with(['User', 'Recipe', 'Replies'])
            ->where('recipe_id', '!=', null)
            ->where('approved', Comment::DB_TRUE)
            ->orderBy('created_at', 'DESC')->take(4)->get();
    }
}
