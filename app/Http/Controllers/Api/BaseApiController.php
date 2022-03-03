<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseApiController extends Controller
{
    protected function getPaginatedData(Collection $collection, int $page, int $perPage): array
    {
        $paginated = $this->createPaginator($collection, count($collection), $perPage, $page);
        $previousPage = $page - 1;

        if($paginated->currentPage() === 1) {
            $previousPage = null;
        }

        $paginator = [
            'page' => $page,
            'next_page' => $page + 1,
            'previous_page' => $previousPage,
            'last_page' => $paginated->lastPage(),
        ];

        return [
            'items' => $paginated->items(),
            'paginator' => $paginator
        ];
    }

    protected function createPaginator(Collection $collection, int $total, int $perPage, int $page): LengthAwarePaginator
    {
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            $collection->slice($offset, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
