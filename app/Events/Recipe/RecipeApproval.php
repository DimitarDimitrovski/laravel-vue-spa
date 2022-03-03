<?php

namespace App\Events\Recipe;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecipeApproval
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $recipeId;
    /**
     * @var string
     */
    public $message;
    /**
     * @var string
     */
    public $admin;

    /**
     * Create a new event instance.
     *
     * @param int $recipeId
     * @param string $message
     * @param string $admin
     */
    public function __construct(int $recipeId, string $message, string $admin)
    {
        $this->recipeId = $recipeId;
        $this->message = $message;
        $this->admin = $admin;
    }
}
