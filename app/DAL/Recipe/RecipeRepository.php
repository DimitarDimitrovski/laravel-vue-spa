<?php


namespace App\DAL\Recipe;


use App\DAL\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface RecipeRepository extends EloquentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function latest(): Collection;

    /**
     * @return Collection
     */
    public function recommended(): Collection;

    /**
     * @return Collection
     */
    public function topRated(): Collection;

    /**
     * @param string $keyword
     * @return Collection
     */
    public function collectionByKeyword(string $keyword): Collection;

    /**
     * @param Model $recipe
     * @return Collection
     */
    public function relatedRecipes(Model $recipe): Collection;

    /**
     * @param int $id
     * @return Collection
     */
    public function userTopRated(int $id): Collection;
}
