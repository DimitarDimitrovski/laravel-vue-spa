<?php

namespace App\Events\Recipe;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecipeUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $recipeId;

    /**
     * Create a new event instance.
     *
     * @param int $recipeId
     */
    public function __construct(int $recipeId)
    {
        $this->recipeId = $recipeId;
    }
}
