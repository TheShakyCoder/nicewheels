<?php

namespace App\Providers;

use App\Services\EbayService;
use Illuminate\Support\ServiceProvider;

class EbayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(EbayService::class, function () {
            return new EbayService();
        });
    }
}
