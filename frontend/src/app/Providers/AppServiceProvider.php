<?php

namespace App\Providers;

use App\Jobs\ArticleParser;
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
        app()->bindMethod(ArticleParser::class. '@handle', fn($job) => $job->handle());
    }
}
