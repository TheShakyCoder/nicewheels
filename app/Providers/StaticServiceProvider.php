<?php

namespace App\Providers;

use App\Services\StaticService;
use Illuminate\Support\ServiceProvider;

class StaticServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StaticService::class, function () {
            return new StaticService();
        });
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
