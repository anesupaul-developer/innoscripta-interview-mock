<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiTransformClass;
use App\Contracts\ArticleRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct(public ArticleRepositoryInterface $articleRepositoryInterface) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $items = $this->articleRepositoryInterface->index();

            $data = [];
            foreach ($items as $article) {
                $data[] = new ArticleResource($article);
            }

            return response()->json(new ApiTransformClass($items, $data));
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to retrieve articles'], Response::HTTP_BAD_REQUEST);
        }
    }
}
