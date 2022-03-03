<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

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
            'title' => $this->faker->text(15),
            'description' => $this->faker->paragraph,
            'rating' => rand(1,5),
            'approved' => 1
        ];
    }
}
