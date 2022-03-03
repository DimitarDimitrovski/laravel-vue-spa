<?php

namespace App\Providers;

use App\DAL\Comment\CommentRepository;
use App\DAL\Comment\EloquentComment;
use App\DAL\EloquentRepositoryImpl;
use App\DAL\EloquentRepositoryInterface;
use App\DAL\Recipe\EloquentRecipe;
use App\DAL\Recipe\RecipeRepository;
use App\DAL\Review\EloquentReview;
use App\DAL\Review\ReviewRepository;
use App\DAL\User\EloquentUser;
use App\DAL\User\UserRepository;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, EloquentRepositoryImpl::class);
        $this->app->bind(UserRepository::class, EloquentUser::class);
        $this->app->bind(RecipeRepository::class, EloquentRecipe::class);
        $this->app->bind(ReviewRepository::class, EloquentReview::class);
        $this->app->bind(CommentRepository::class, EloquentComment::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $admins = User::where('role', 'admin')->get(['name', 'email']);
        config(['mail.recipients.admins' => $admins]);
    }
}
