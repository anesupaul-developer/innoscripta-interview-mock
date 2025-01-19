<?php

use App\Http\Controllers\Api\ArticleController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//    return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');

    Route::get('categories', function () {
        return Article::select('category')->whereNotNull('category')->distinct()->pluck('category');
    });
});
