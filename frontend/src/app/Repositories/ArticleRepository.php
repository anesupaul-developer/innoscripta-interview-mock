<?php

namespace App\Repositories;

use App\Contracts\ArticleRepositoryInterface;
use App\Models\Article as ArticleModel;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function index(){
        return ArticleModel::all();
    }

    public function getById($id){
        return ArticleModel::findOrFail($id);
    }

    public function store(array $data){
        return ArticleModel::create($data);
    }

    public function update(array $data,$id){
        return ArticleModel::whereId($id)->update($data);
    }

    public function delete($id){
        ArticleModel::destroy($id);
    }
}
