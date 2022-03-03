<?php


namespace App\DAL\Recipe;

use App\DAL\EloquentRepositoryImpl;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EloquentRecipe extends EloquentRepositoryImpl implements RecipeRepository
{
    public function __construct(Recipe $model)
    {
        parent::__construct($model);
    }

    public function latest(): Collection
    {
        return $this->newQuery()
            ->with(['User'])->where('approved', Recipe::DB_TRUE)
            ->orderBy('id', 'desc')->take(Recipe::DEFAULT_RECORD_LIMIT)->get();
    }

    public function recommended(): Collection
    {
        return $this->newQuery()
            ->with(['User'])
            ->where('approved', Recipe::DB_TRUE)
            ->where('recommended', Recipe::DB_TRUE)->take(Recipe::DEFAULT_RECORD_LIMIT)->get();
    }

    public function topRated(): Collection
    {
        return $this->newQuery()
            ->with(['User'])
            ->where('recipes.approved', Recipe::DB_TRUE)
            ->where('reviews.approved', Recipe::DB_TRUE)
            ->join('reviews', 'reviews.recipe_id', '=', 'recipes.id')
            ->select(array('recipes.*',
                DB::raw('AVG(rating) as average_rating')
            ))
            ->groupBy('id')
            ->orderBy('average_rating', 'DESC')
            ->take(Recipe::TOP_RATED_LIMIT)
            ->get();
    }

    public function collectionByKeyword(string $keyword): Collection
    {
        return $this->newQuery()->with(['User'])->where('approved', Recipe::DB_TRUE)
            ->where('name', 'LIKE', '%'.$keyword.'%')->get();
    }

    public function relatedRecipes(Model $recipe): Collection
    {
        $searchKeywords = explode(' ', $recipe->name);
        $collection = $this->newQuery()->where('approved', Recipe::DB_TRUE)
            ->where('id', '!=', $recipe->id)
            ->where(function($query) use ($searchKeywords) {
                foreach ($searchKeywords as $searchKeyword) {
                    $query->orWhere('name', 'LIKE', '%'.$searchKeyword.'%');
                }
            })->take(Recipe::DEFAULT_RECORD_LIMIT)->get();

        if($collection->count() < 3) {
            $collection = $this->newQuery()->where('approved', Recipe::DB_TRUE)
                ->where('type', '=', $recipe->type)->take(Recipe::DEFAULT_RECORD_LIMIT)->get();
        }

        return $collection;
    }

    public function userTopRated(int $id): Collection
    {
        return $this->newQuery()
            ->join('reviews', 'reviews.recipe_id', '=', 'recipes.id')
            ->where('recipes.approved', Recipe::DB_TRUE)
            ->where('reviews.approved', Recipe::DB_TRUE)
            ->select(array('recipes.*',
                DB::raw('AVG(rating) as average_rating')
            ))
            ->groupBy('id')
            ->orderBy('average_rating', 'DESC')
            ->where('recipes.user_id', $id)
            ->take(Recipe::DEFAULT_RECORD_LIMIT)
            ->get();
    }
}
