<?php

namespace App\Http\Controllers;

use App\DAL\Review\ReviewRepository;
use App\Events\Review\ReviewApproval;
use App\Http\Requests\ApprovalRequest;

class ReviewsController extends Controller
{
    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function index()
    {
        $reviews = $this->reviewRepository->all(['*'], ['User', 'Recipe']);
        $deletedReviews = $this->reviewRepository->newQuery()->onlyTrashed()->get()
            ->load([
                'User' => function($query) { $query->withTrashed(); },
                'Recipe' => function($query) { $query->withTrashed(); }
            ]);
        $data = compact('reviews', 'deletedReviews');

        return view('admin.reviews.index', $data);
    }

    public function show($id)
    {
        $review = $this->reviewRepository->findWithRelations($id, ['User', 'Recipe']);
        $data = compact('review');

        return view('admin.reviews.show', $data);
    }

    public function destroy($id)
    {
        $review = $this->reviewRepository->findOrFail($id);
        $review->delete();

        return response()->json(['status' => 'success', 'message' => 'Review was deleted successfully']);
    }

    public function approval($id, ApprovalRequest $request)
    {
        $review = $this->reviewRepository->findOrFail($id);
        $params = $request->only(['approved']);
        $review->update($params);
        event(new ReviewApproval($review->id, auth()->user()->name, $request->get('message')));

        return redirect()->back()->with(['message' => 'Review approval status was set successfully']);
    }
}
