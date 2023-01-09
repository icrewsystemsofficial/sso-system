<?php

namespace Icrewsystems\SsoLogin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SsoLoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // dd('it works');
        $this->registerRoutes();
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sso');
    }
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('sso.prefix'),
            'middleware' => config('sso.middleware'),
        ];
    }


    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'sso');
    }
}
