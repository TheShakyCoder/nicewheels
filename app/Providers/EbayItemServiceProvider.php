<?php

namespace App\Providers;

use App\Services\EbayItemService;
use Illuminate\Support\ServiceProvider;

class EbayItemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(EbayItemService::class, function () {
            return new EbayItemService();
        });
    }
}
