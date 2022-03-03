<?php

namespace App\Providers;

use App\Events\Comment\CommentApproval;
use App\Events\Comment\CommentCreated;
use App\Events\Recipe\RecipeApproval;
use App\Events\Recipe\RecipeCreated;
use App\Events\Recipe\RecipeUpdated;
use App\Events\Review\ReviewApproval;
use App\Events\Review\ReviewCreated;
use App\Events\Review\ReviewUpdated;
use App\Listeners\Comment\CommentApprovalListener;
use App\Listeners\Comment\CommentCreatedListener;
use App\Listeners\Recipe\RecipeApprovalListener;
use App\Listeners\Recipe\RecipeCreatedListener;
use App\Listeners\Recipe\RecipeUpdatedListener;
use App\Listeners\Review\ReviewApprovalListener;
use App\Listeners\Review\ReviewCreatedListener;
use App\Listeners\Review\ReviewUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        RecipeCreated::class => [
            RecipeCreatedListener::class
        ],

        RecipeApproval::class => [
            RecipeApprovalListener::class
        ],

        RecipeUpdated::class => [
            RecipeUpdatedListener::class
        ],

        ReviewCreated::class => [
            ReviewCreatedListener::class
        ],

        ReviewApproval::class => [
            ReviewApprovalListener::class
        ],

        ReviewUpdated::class => [
            ReviewUpdatedListener::class
        ],

        CommentCreated::class => [
            CommentCreatedListener::class
        ],

        CommentApproval::class => [
            CommentApprovalListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
