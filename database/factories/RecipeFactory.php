<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $recipeTypes = ['sweet', 'salty'];
        $recipeKey = array_rand($recipeTypes);
        $recipeType = $recipeTypes[$recipeKey];

        $preparationLevels = ['easy', 'medium', 'hard'];
        $preparationLevelKey = array_rand($preparationLevels);
        $preparationLevel = $preparationLevels[$preparationLevelKey];

        $preparationTimes = ['30', '30-60', '60-120', '120-180', '180'];
        $preparationTimeKey = array_rand($preparationTimes);
        $preparationTime = $preparationTimes[$preparationTimeKey];

        $recipeFeaturedImgs = ['recipe_default_1.jpg', 'recipe_default_2.jpg', 'recipe_default_3.jpg', 'recipe_default_4.jpg'];
        $recipeFeaturedImgKey = array_rand($recipeFeaturedImgs);
        $recipeFeaturedImg = $recipeFeaturedImgs[$recipeFeaturedImgKey];
        $randUser = User::where('role', 'regular')->with('recipes')->get()->random();

        $additionalImages = ['recipe_1.jpg', 'recipe_2.jpg', 'recipe_3.jpg', 'recipe_4.jpg',
            'recipe_5.jpg', 'recipe_6.jpg', 'recipe_7.jpg', 'recipe_8.jpg'];
        $randKeys = array_rand($additionalImages, 4);
        $randomRecipeImgs = [];

        foreach ($randKeys as $randKey) {
            $randomRecipeImgs[] = $additionalImages[$randKey];
        }

        return [
            'user_id' => $randUser->id,
            'name' => $this->faker->text(15),
            'description' => $this->faker->paragraph(20),
            'featured_image' => $recipeFeaturedImg,
            'additional_images' => $randomRecipeImgs,
            'type' => $recipeType,
            'preparation_time' => $preparationTime,
            'preparation_level' => $preparationLevel,
            'ingredients' => ['Ingredient 1', 'Ingredient 2', 'Ingredient 3', 'Ingredient 4', 'Ingredient 5'],
            'recommended' => rand(0, 1),
            'approved' => 1
        ];
    }
}
