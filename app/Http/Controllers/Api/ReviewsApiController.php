<?php

namespace App\Http\Controllers\Api;

use App\DAL\Review\ReviewRepository;
use App\Events\Review\ReviewCreated;
use App\Events\Review\ReviewUpdated;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewsApiController extends BaseApiController
{
    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        parent::__construct();
        $this->reviewRepository = $reviewRepository;
    }

    public function store(StoreReviewRequest $request): JsonResponse
    {
        $params = $request->only(['recipe_id', 'user_id', 'title', 'description', 'rating']);
        $review = $this->reviewRepository->create($params);
        event(new ReviewCreated($review->id));

        return response()->json(
            ['message' => 'Your review was created successfully. Please wait while admin reviews it for approval.'], 200
        );
    }

    public function updateReview(UpdateReviewRequest $request): JsonResponse
    {
        $review = $this->reviewRepository->findOrFail($request->get('id'));
        $params = $request->only(['title', 'description', 'rating']);
        $params['approved'] = Review::DB_FALSE;
        $review->update($params);
        event(new ReviewUpdated($review->id));

        return response()->json(
            ['message' => 'Your review was updated successfully. Please wait while admin reviews it for approval.'], 200
        );
    }
}
