<?php

namespace App\Repositories;

use App\Contracts\ArticleRepositoryInterface;
use App\Models\Article as ArticleModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        $perPage = request()->query('perPage') ?? 9;

        $category = request()->query('category');

        $search = request()->query('q');

        return ArticleModel::query()
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when($search, function ($query, $searchTerm) {
                return $query->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            })
            ->paginate($perPage);
    }

    public function getById($id)
    {
        return ArticleModel::findOrFail($id);
    }

    public function store(array $data)
    {
        return ArticleModel::create($data);
    }

    public function update(array $data, $id)
    {
        return ArticleModel::whereId($id)->update($data);
    }

    public function delete($id)
    {
        ArticleModel::destroy($id);
    }
}
