<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecipeApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $user;
    /**
     * @var string
     */
    public $admin;
    /**
     * @var Model
     */
    public $recipe;
    /**
     * @var string
     */
    public $message;

    /**
     * Create a new message instance.
     *
     * @param string $user
     * @param string $admin
     * @param Model $recipe
     * @param string $message
     */
    public function __construct(string $user, string $admin, Model $recipe, string $message)
    {
        $this->user = $user;
        $this->admin = $admin;
        $this->recipe = $recipe;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.recipe.approval');
    }
}
