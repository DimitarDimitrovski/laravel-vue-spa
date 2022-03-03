<?php


namespace App\DAL\User;

use App\DAL\EloquentRepositoryImpl;
use App\Models\User;

class EloquentUser extends EloquentRepositoryImpl implements UserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
