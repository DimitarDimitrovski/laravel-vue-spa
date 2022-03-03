<?php

namespace App\Mail;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecipeCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var int
     */
    public $recipeId;
    /**
     * @var User
     */
    public $user;
    /**
     * @var User
     */
    public $admin;

    /**
     * Create a new message instance.
     *
     * @param int $recipeId
     * @param string $user
     * @param string $admin
     */
    public function __construct(int $recipeId, string $user, string $admin)
    {
        $this->recipeId = $recipeId;
        $this->user = $user;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.recipe.created');
    }
}
