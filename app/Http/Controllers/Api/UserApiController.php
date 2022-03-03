<?php

namespace App\Http\Controllers\Api;

use App\DAL\Recipe\RecipeRepository;
use App\DAL\User\UserRepository;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\UserResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class UserApiController extends BaseApiController
{
    /**
     * @var UserRepository
     * @var RecipeRepository
     */
    private $userRepository;
    private $recipeRepository;

    public function __construct(UserRepository $userRepository, RecipeRepository $recipeRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->recipeRepository = $recipeRepository;
    }

    public function index(): array
    {
        $collection = $this->userRepository->newQuery()->where('role', '=', 'regular')
            ->with(['Recipes' => function($query) {
                $query->where('approved', Recipe::DB_TRUE);
                $query->orderBy('id', 'DESC');
            }
            ])
            ->withCount(['Recipes' => function($query) { $query->where('approved', Recipe::DB_TRUE);}])
            ->orderBy('recipes_count', 'DESC')
            ->get();

        $page = request()->has('page') ? request('page') : 1;
        $perPage = 10;
        $paginatedData = $this->getPaginatedData($collection, $page, $perPage);

        return [
            'data' => UserResource::collection($paginatedData['items']),
            'paginator' => $paginatedData['paginator']
        ];
    }

    public function show($id): array
    {
        return [
            'data' => UserResource::make(
                    $this->userRepository->newQuery()->with(['Recipes' => function($query) {
                        $query->where('approved', Recipe::DB_TRUE);
                        $query->orderBy('id', 'DESC');
                        $query->limit(6);
                    }
                ])->findOrFail($id)
            ),
            'recipesCount' => $this->userRepository->findOrFail($id)->recipesCount()
        ];
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->findOrFail($request->get('id'));
        $params = $request->except(['id']);
        $params['image'] = $user->image;

        if($request->get('image') != null) {
            $hashName = $request->file('image')->hashName();
            $request->file('image')->storeAs('avatars', $hashName, 'avatars_upload');
            $params['image'] = $hashName;
        }

        $user->update($params);

        return response()->json($user);
    }

    public function recipes($id): array
    {
        $user = $this->userRepository->findOrfail($id);
        $collection = $this->recipeRepository->newQuery()
            ->where('user_id', $id)->where('approved', Recipe::DB_TRUE)->get();
        $page = request()->has('page') ? request('page') : 1;
        $perPage = 15;
        $paginatedData = $this->getPaginatedData($collection, $page, $perPage);

        return [
            'data' => RecipeResource::collection($paginatedData['items']),
            'paginator' => $paginatedData['paginator'],
            'userName' => $user->name
        ];
    }

    public function profile($id) {
        $recipes = $this->recipeRepository->newQuery()->where('user_id', $id)
            ->orderBy('id', 'DESC')->get();
        $page = request()->has('page') ? request('page') : 1;
        $perPage = 9;
        $paginatedData = $this->getPaginatedData($recipes, $page, $perPage);

        return [
            'topRated' => $this->recipeRepository->userTopRated($id),
            'recipes' => RecipeResource::collection($paginatedData['items']),
            'paginator' => $paginatedData['paginator'],
            'recipesCount' => $this->userRepository->findOrFail($id)->recipesCount()
        ];
    }
}
