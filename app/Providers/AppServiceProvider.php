<?php

namespace App\Providers;

use App\Services\CoingekoApiService;
use App\Services\Interfaces\CoingekoApiServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CoingekoApiServiceInterface::class, function ($app) {
            return new CoingekoApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
