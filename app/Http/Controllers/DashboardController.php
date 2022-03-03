<?php

namespace App\Http\Controllers;

use App\DAL\Comment\CommentRepository;
use App\DAL\Recipe\RecipeRepository;
use App\DAL\Review\ReviewRepository;
use App\DAL\User\UserRepository;
use Carbon\Carbon;
use DateTime;

class DashboardController extends Controller
{
    /**
     * @var UserRepository
     * @var RecipeRepository
     * @var ReviewRepository
     * @var CommentRepository
     */
    private $userRepository;
    private $recipeRepository;
    private $reviewRepository;
    private $commentRepository;

    public function __construct(
        UserRepository $userRepository,
        RecipeRepository $recipeRepository,
        ReviewRepository $reviewRepository,
        CommentRepository $commentRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->recipeRepository = $recipeRepository;
        $this->reviewRepository = $reviewRepository;
        $this->commentRepository = $commentRepository;
    }

    public function index() {
        $now = Carbon::now();
        $q1EndDate = "{$now->year}-04-01";
        $q2EndDate = "{$now->year}-07-01";
        $q3EndDate = "{$now->year}-10-01";
        $totalReviews = $this->reviewRepository->count();

        $widgetData = [
            'cooks' => $this->userRepository->newQuery()->where('role', 'regular')->count(),
            'recipes' => $this->recipeRepository->count(),
            'ratings' => $this->reviewRepository->count(),
            'comments' => $this->commentRepository->count()
        ];

        $users = $this->userRepository->newQuery()
            ->select('id', 'created_at')->where('role', 'regular')->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            });

        $userMonthCount = [];
        $userYearly = [];

        foreach ($users as $key => $value) {
            $userMonthCount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++) {
            $dateObj = DateTime::createFromFormat('!m', $i);
            $monthName = $dateObj->format('m');
            $count = 0;

            if (!empty($userMonthCount[$i])) {
                $count = $userMonthCount[$i];
            }

            $month = [
                'month' => "{$now->year}-{$monthName}",
                'value' => $count
            ];
            $userYearly[] = $month;
        }

        $recipeData = [
            [
                'quarter' => "{$now->year} Q1",
                'easy' => $this->recipeRepository->newQuery()
                    ->where('created_at', '<', $q1EndDate )->where('preparation_level', 'easy')->count(),
                'medium' => $this->recipeRepository->newQuery()
                    ->where('created_at', '<', $q1EndDate )->where('preparation_level', 'medium')->count(),
                'hard' => $this->recipeRepository->newQuery()
                    ->where('created_at', '<', $q1EndDate )->where('preparation_level', 'hard')->count(),
            ],
            [
                'quarter' => "{$now->year} Q2",
                'easy' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q1EndDate )
                    ->where('created_at', '<', $q2EndDate)->where('preparation_level', 'easy')->count(),
                'medium' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q1EndDate )
                    ->where('created_at', '<', $q2EndDate)->where('preparation_level', 'medium')->count(),
                'hard' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q1EndDate )
                    ->where('created_at', '<', $q2EndDate)->where('preparation_level', 'hard')->count(),
            ],
            [
                'quarter' => "{$now->year} Q3",
                'easy' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q2EndDate )
                    ->where('created_at', '<', $q3EndDate)->where('preparation_level', 'easy')->count(),
                'medium' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q2EndDate )
                    ->where('created_at', '<', $q3EndDate)->where('preparation_level', 'medium')->count(),
                'hard' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q2EndDate )
                    ->where('created_at', '<', $q3EndDate)->where('preparation_level', 'hard')->count(),
            ],
            [
                'quarter' => "{$now->year} Q4",
                'easy' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q3EndDate )
                    ->where('preparation_level', 'easy')->count(),
                'medium' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q3EndDate )
                    ->where('preparation_level', 'medium')->count(),
                'hard' => $this->recipeRepository->newQuery()->where('created_at', '>=', $q3EndDate )
                    ->where('preparation_level', 'hard')->count(),
            ]
        ];

        $comments = $this->commentRepository->newQuery()->select('id', 'created_at')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $commentData = [];

        foreach ($comments as $key => $value) {
            $commentData[] = [
                'date' => $key,
                'comments' => count($value)
            ];
        }

        $reviewData = [
            [
                'value' => $this->calculatePercent($this->reviewRepository->newQuery()
                    ->where('rating', 5)->count(), $totalReviews),
                'label' => '5 Stars'
            ],
            [
                'value' => $this->calculatePercent($this->reviewRepository->newQuery()
                    ->where('rating', 4)->count(), $totalReviews),
                'label' => '4 Stars'
            ],
            [
                'value' => $this->calculatePercent($this->reviewRepository->newQuery()
                    ->where('rating', 3)->count(), $totalReviews),
                'label' => '3 Stars'
            ],
            [
                'value' => $this->calculatePercent($this->reviewRepository->newQuery()
                    ->where('rating', 2)->count(), $totalReviews),
                'label' => '2 Stars'
            ],
            [
                'value' => $this->calculatePercent($this->reviewRepository->newQuery()
                    ->where('rating', 1)->count(), $totalReviews),
                'label' => '1 Star'
            ],
        ];

        $data = compact('widgetData','userYearly', 'recipeData', 'commentData', 'reviewData');

        return view('admin.dashboard', $data);
    }

    private function calculatePercent(int $items, int $total): float {
        return round($items / $total * 100, 2);
    }
}
