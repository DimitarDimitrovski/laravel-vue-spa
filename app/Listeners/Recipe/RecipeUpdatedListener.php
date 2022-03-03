<?php

namespace App\Listeners\Recipe;

use App\DAL\Recipe\RecipeRepository;
use App\Events\Recipe\RecipeUpdated;
use App\Mail\RecipeUpdatedMail;
use Illuminate\Support\Facades\Mail;

class RecipeUpdatedListener
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * Create the event listener.
     *
     * @param RecipeRepository $recipeRepository
     */
    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * Handle the event.
     *
     * @param  RecipeUpdated  $event
     * @return void
     */
    public function handle(RecipeUpdated $event)
    {
        $recipe = $this->recipeRepository->findWithRelations($event->recipeId, ['User']);
        $author = $recipe->User->name;

        foreach (config('mail.recipients.admins') as $admin) {
            Mail::to($admin->email)->send(new RecipeUpdatedMail($event->recipeId, $author, $admin->name));
        }
    }
}
