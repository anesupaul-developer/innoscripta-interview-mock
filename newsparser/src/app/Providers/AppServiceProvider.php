<?php

namespace App\Providers;

use App\Contracts\ArticleReaderInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //        $this->app->bind(ArticleReaderInterface::class, function ($app) {
        //            return new ClicknPayStripeGateway(config('services.clicknpay_stripe.publisher_key'), 'USD');
        //        });
    }
}
