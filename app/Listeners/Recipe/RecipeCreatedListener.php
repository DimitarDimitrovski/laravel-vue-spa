<?php

namespace App\Listeners\Recipe;

use App\DAL\Recipe\RecipeRepository;
use App\Events\Recipe\RecipeCreated;
use App\Mail\RecipeCreatedMail;
use Illuminate\Support\Facades\Mail;

class RecipeCreatedListener
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
     * @param RecipeCreated $event
     * @return void
     */
    public function handle(RecipeCreated $event)
    {
        $recipe = $this->recipeRepository->findWithRelations($event->recipeId, ['User']);
        $user = $recipe->User->name;

        foreach (config('mail.recipients.admins') as $admin) {
            Mail::to($admin->email)->send(new RecipeCreatedMail($event->recipeId, $user, $admin->name));
        }
    }
}
