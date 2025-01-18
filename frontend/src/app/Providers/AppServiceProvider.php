<?php

namespace App\Providers;

use App\Jobs\ArticleParser;
use App\Jobs\OnNewArticleGenerated;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        App::bindMethod(ArticleParser::class, function ($job) {
            return $job->handle();
        });

        App::bindMethod(OnNewArticleGenerated::class, function ($job) {
            return $job->handle();
        });

        // app()->bindMethod(ArticleParser::class. '@handle', fn($job) => $job->handle());
    }
}
