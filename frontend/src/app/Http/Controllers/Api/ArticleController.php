<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiResponseClass;
use App\Contracts\ArticleRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function __construct(public ArticleRepositoryInterface $articleRepositoryInterface)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = $this->articleRepositoryInterface->index();

        return ApiResponseClass::sendResponse(ArticleResource::collection($data));
    }
}
