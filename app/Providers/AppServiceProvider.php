<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ZkLoginService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind ZkLoginService as a singleton
        $this->app->singleton(ZkLoginService::class, function($app) {
            return new ZkLoginService();
        });
    }

    public function boot()
    {
        //
    }
}
