<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::where('role', 'regular')->get()->random()->id,
            'recipe_id' => Recipe::all()->random()->id,
            'content' => $this->faker->text(150),
            'approved' => 1
        ];
    }

    public function nested()
    {
        return $this->state([
            'recipe_id' => null,
            'parent_id' => Comment::where('recipe_id', '!=', null)->get()->random()->id
        ]);
    }
}
