<?php


namespace App\DAL\Review;

use App\DAL\EloquentRepositoryImpl;
use App\Models\Review;

class EloquentReview extends EloquentRepositoryImpl implements ReviewRepository
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }
}
