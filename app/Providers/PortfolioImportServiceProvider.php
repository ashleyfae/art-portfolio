<?php

namespace App\Providers;

use App\Services\PortfolioProviders\Contracts\PortfolioProvider;
use App\Services\PortfolioProviders\DeviantArt;
use Illuminate\Support\ServiceProvider;

class PortfolioImportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PortfolioProvider::class, DeviantArt::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
