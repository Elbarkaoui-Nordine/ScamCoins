<?php

namespace App\Providers;

use App\Services\CoingekoApiService;
use App\Services\Interfaces\CoingekoApiServiceInterface;
use Illuminate\Support\ServiceProvider;

class CoingekoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CoingekoApiServiceInterface::class, CoingekoApiService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 