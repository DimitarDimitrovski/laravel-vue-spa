<?php


namespace App\DAL\Comment;


use App\DAL\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepository extends EloquentRepositoryInterface
{
    public function latest(): Collection;
}
