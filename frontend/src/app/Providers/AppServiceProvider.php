<?php

namespace App\Providers;

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
        App::bindMethod(OnNewArticleGenerated::class, function ($job) {
            return $job->handle();
        });
    }
}
