<?php

namespace App\Listeners\Recipe;

use App\DAL\Recipe\RecipeRepository;
use App\Events\Recipe\RecipeApproval;
use App\Mail\RecipeApprovalMail;
use Illuminate\Support\Facades\Mail;

class RecipeApprovalListener
{
    /**
     * @var RecipeRepository
     */
    public $recipeRepository;

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
     * @param  object  $event
     * @return void
     */
    public function handle(RecipeApproval $event)
    {
        $recipe = $this->recipeRepository->findWithRelations($event->recipeId, ['User']);
        Mail::to($recipe->User->email)
            ->send(new RecipeApprovalMail($recipe->User->name, $event->admin, $recipe, $event->message));

    }
}
