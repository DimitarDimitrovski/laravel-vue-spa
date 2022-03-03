<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecipeUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipeId;
    public $author;
    public $admin;

    /**
     * Create a new message instance.
     *
     * @param $recipeId
     * @param $author
     * @param $admin
     */
    public function __construct($recipeId, $author, $admin)
    {
        $this->recipeId = $recipeId;
        $this->author = $author;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.recipe.updated');
    }
}
