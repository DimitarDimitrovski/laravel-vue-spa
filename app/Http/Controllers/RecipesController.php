<?php

namespace App\Http\Controllers;

use App\DAL\Recipe\RecipeRepository;
use App\Events\Recipe\RecipeApproval;
use App\Http\Requests\ApprovalRequest;

class RecipesController extends BaseController
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    public function index()
    {
        $recipes = $this->recipeRepository->all(['*'], ['User']);
        $deletedRecipes = $this->recipeRepository->newQuery()
            ->onlyTrashed()->get()->load(['User' => function($query) { $query->withTrashed();}]);
        $data = compact('recipes', 'deletedRecipes');

        return view('admin.recipes.index', $data);
    }

    public function show($id)
    {
        $recipe = $this->recipeRepository->findOrFail($id);
        $data = compact('recipe');

        return view('admin.recipes.show', $data);
    }

    public function destroy($id)
    {
        $recipe = $this->recipeRepository->findWithRelations($id, ['Comments', 'Reviews']);

        if($recipe->Comments) {
            $this->deleteComments($recipe->Comments);
        }

        if($recipe->Reviews) {
            foreach ($recipe->Reviews as $review) {
                $review->delete();
            }
        }

        $recipe->delete();

        return response()->json(['status' => 'success', 'message' => 'Recipe was deleted successfully']);
    }

    public function approval($id, ApprovalRequest $request)
    {
        $recipe = $this->recipeRepository->findOrFail($id);
        $params = $request->only(['approved']);
        $recipe->update($params);
        event(new RecipeApproval($id, $request->get('message'), auth()->user()->name));

        return redirect()->back()->with(['message' => 'Recipe approval status was set successfully']);
    }
}
