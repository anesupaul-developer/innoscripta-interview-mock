<?php

namespace App\Classes;

use Illuminate\Pagination\LengthAwarePaginator;

final class ApiTransformClass
{
    public int|string|null $total = 0;

    public int|string|null $last_id;

    public int|string|null $per_page = 0;

    public int|string|null $current_page = 0;

    public array $items = [];

    public int|string|null $next_page = 0;

    public int|string|null $prev_page;

    public function __construct(LengthAwarePaginator $paginator, $data = [])
    {
        $this->total = $paginator->total();

        $this->per_page = $paginator->perPage();

        $this->current_page = $paginator->currentPage();

        $this->prev_page = $this->current_page - 1;

        $this->next_page = $this->getNextPage($paginator);

        $this->items = $data;

        if ($paginator->total() > 0) {
            $this->last_id = $paginator->last() ? $paginator->last()->id : 0;
        }
    }

    private function getNextPage(LengthAwarePaginator $paginator): int
    {
        $page = $this->current_page + 1;

        if ($this->current_page == $paginator->lastPage()) {
            return 0;
        }

        if ($page > $paginator->lastPage()) {
            return 0;
        }

        return $page;
    }
}
