<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ArrayPaginator
{
    /**
     * Paginates an array.
     *
     * @param array $items The array to paginate.
     * @param int $perPage Items per page.
     * @param int|null $currentPage Current page to display, auto-calculated if null.
     * @param array $options Additional options for the paginator.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function paginate(array $items, int $perPage = 15, int $currentPage = null, array $options = []): LengthAwarePaginator
    {
        // Convert the array to a collection
        $collection = collect($items);

        // Default the current page to the current Paginator page or a manual entry
        $currentPage = $currentPage ?: Paginator::resolveCurrentPage();

        // Define the offset for slicing the collection
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Create and return the paginator
        return new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            $options + [
                'path' => Paginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );
    }
}

