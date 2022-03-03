<?php

namespace App\Http\Controllers;

use App\DAL\Recipe\RecipeRepository;
use App\DAL\User\UserRepository;

class UsersController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * UsersController constructor.
     * @param UserRepository $userRepository
     * @param RecipeRepository $recipeRepository
     */
    public function __construct(UserRepository $userRepository, RecipeRepository $recipeRepository)
    {
        $this->userRepository = $userRepository;
        $this->recipeRepository = $recipeRepository;
    }

    public function index()
    {
        $cooks = $this->userRepository->newQuery()->where('role', 'regular')->get();
        $deletedCooks = $this->userRepository->newQuery()->onlyTrashed()->where('role', 'regular')->get();
        $data = compact('cooks', 'deletedCooks');

        return view('admin.users.index', $data);
    }

    public function show($id)
    {
        $user = $this->userRepository->newQuery()
            ->with(['Recipes', 'Comments', 'Reviews'])->withCount(['Recipes', 'Comments', 'Reviews'])->findOrFail($id);
        $data = compact('user');

        return view('admin.users.show', $data);
    }

    public function destroy($id)
    {
        $user = $this->userRepository->findWithRelations($id, ['Comments', 'Reviews']);

        if($user->Comments) {
            $this->deleteComments($user->Comments);
        }

        if($user->Reviews) {
            foreach ($user->Reviews as $review) {
                $review->delete();
            }
        }

        $userRecipes = $this->recipeRepository->newQuery()
            ->where('user_id', $user->id)->get()->load(['Comments', 'Reviews']);

        foreach ($userRecipes as $userRecipe) {
            if($userRecipe->Comments) {
                $this->deleteComments($userRecipe->Comments);
            }

            if($userRecipe->Reviews) {
                foreach ($userRecipe->Reviews as $review) {
                    $review->delete();
                }
            }

            $userRecipe->delete();
        }

        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'User was deleted successfully']);
    }
}
