<?php

namespace App\Http\Controllers\Api;

use App\DAL\Recipe\RecipeRepository;
use App\DAL\Review\ReviewRepository;
use App\Events\Recipe\RecipeCreated;
use App\Events\Recipe\RecipeUpdated;
use App\Http\Requests\Recipe\CreateRecipeRequest;
use App\Http\Requests\Recipe\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\ReviewResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeApiController extends BaseApiController
{
    /**
     * @var RecipeRepository
     * @var ReviewRepository
     */
    private $recipeRepository;
    private $reviewRepository;

    public function __construct(RecipeRepository $recipeRepository, ReviewRepository $reviewRepository)
    {
        parent::__construct();
        $this->recipeRepository = $recipeRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function index(Request $request)
    {
        switch ($request->get('action')) {
            case 'latest': {
                return RecipeResource::collection($this->recipeRepository->latest());
            }
            case 'recommended': {
                return RecipeResource::collection($this->recipeRepository->recommended());
            }
            case 'top-rated': {
                return RecipeResource::collection($this->recipeRepository->topRated());
            }
            case 'related': {
                $recipe = $this->recipeRepository->findOrFail(request('id'));
                return RecipeResource::collection($this->recipeRepository->relatedRecipes($recipe));
            }
            case 'search': {
                $collection = $this->recipeRepository->collectionByKeyword(request('keyword'));
                $page = request()->has('page') ? request('page') : 1;
                $paginatedData = $this->getPaginatedData($collection, $page, 9);

                return [
                    'data' => RecipeResource::collection($paginatedData['items']),
                    'paginator' => $paginatedData['paginator']
                ];
            }
            default: {
                $collection = $this->recipeRepository->newQuery()
                    ->with(['User'])->where('approved', Recipe::DB_TRUE)->get();
                $page = request()->has('page') ? request('page') : 1;
                $paginatedData = $this->getPaginatedData($collection, $page, 9);

                return [
                    'data' => RecipeResource::collection($paginatedData['items']),
                    'paginator' => $paginatedData['paginator']
                ];
            }
        }
    }

    public function show($id, Request $request): array
    {
        $userReview = null;
        $authUser = auth('api')->user();

        if ($authUser) {
            $userReview = $this->reviewRepository->newQuery()
                ->where('recipe_id', $id)->where('user_id', $authUser->id)->first();

            if($userReview) {
                $userReview->only(['id', 'title', 'description', 'rating', 'approved']);
            }
        }

        $approved = Recipe::DB_TRUE;

        if($request->get('action') === 'edit') {
            $approved = Recipe::DB_FALSE;
        }

        return [
            'recipe' => RecipeResource::make(
                $this->recipeRepository->newQuery()
                ->where('approved', $approved)->with(['User', 'Comments', 'Reviews' => function($query) {
                    $query->orderBy('id', 'DESC');
                    $query->limit(3);
                }])->findOrFail($id)
            ),
            'reviewsCount' => $this->recipeRepository->findOrFail($id)->reviewsCount(),
            'userReview' => $userReview
        ];
    }

    public function store(CreateRecipeRequest $request): JsonResponse {
        $params = $request->only(['user_id', 'name', 'description', 'type', 'preparation_time', 'preparation_level',
            'ingredients', 'featured_image', 'featured_image', 'additional_images']);
        $additionalImages = [];

        if($request->file('additional_images') !== null) {
            foreach ($request->file('additional_images') as $additionalImage) {
                $hashName = $additionalImage->hashName();
                $additionalImage->storeAs('images', $hashName, 'recipes_images');
                $additionalImages[] = $hashName;
            }

            $params['additional_images'] = $additionalImages;
        }

        if($request->file('featured_image') !== null) {
            $hashName = $request->file('featured_image')->hashName();
            $request->file('featured_image')->storeAs('images', $hashName, 'recipes_images');
            $params['featured_image'] = $hashName;
        }

        $recipe = $this->recipeRepository->create($params);
        event(new RecipeCreated($recipe->id));

        return response()->json(
            ['message' => 'Recipe was created successfully. Please wait while admin reviews it for approval.'], 200
        );
    }

    public function update($id, UpdateRecipeRequest $request): JsonResponse
    {
        $recipe = $this->recipeRepository->findOrFail($id);
        $params = $request->only(['user_id', 'name', 'description', 'type', 'preparation_time', 'preparation_level',
            'ingredients', 'featured_image', 'featured_image', 'additional_images']);
        $additionalImages = $request->get('additional_images');

        if($request->file('new_featured_image') !== null) {
            $hashName = $request->file('new_featured_image')->hashName();
            $request->file('new_featured_image')->storeAs('images', $hashName, 'recipes_images');
            $params['featured_image'] = $hashName;
        }

        if($request->file('new_additional_images') !== null) {
            foreach ($request->file('new_additional_images') as $additionalImage) {
                $hashName = $additionalImage->hashName();
                $additionalImage->storeAs('images', $hashName, 'recipes_images');
                $additionalImages[] = $hashName;
            }

            $params['additional_images'] = $additionalImages;
        }

        if($recipe->approved === Recipe::DB_TRUE) {
            $params['approved'] = Recipe::DB_FALSE;
        }

        event(new RecipeUpdated($recipe->id));
        $recipe->update($params);

        return response()->json(['message' => 'Recipe was updated successfully. Please wait while admin reviews the changes'], 200);
    }

    public function reviews($id): array
    {
        $collection = $this->reviewRepository->newQuery()
            ->where('recipe_id', $id)->where('approved', Recipe::DB_TRUE)->get();
        $page = request()->has('page') ? request('page') : 1;
        $perPage = 20;
        $paginatedData = $this->getPaginatedData($collection, $page, $perPage);

        return [
            'data' => ReviewResource::collection($paginatedData['items']),
            'paginator' => $paginatedData['paginator'],
            'recipeName' => $this->recipeRepository->findOrFail($id)->name
        ];
    }
}
