<?php

namespace Icrewsystems\SsoLogin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SsoLoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sso');
        if ($this->app->runningInConsole()) {
            // Publish view components
            $this->publishes([
                __DIR__.'/../src/View/Components/' => app_path('View/Components'),
                __DIR__.'/../resources/views/components/' => resource_path('views/components'),
            ], 'sso-login-compoenent');
          }
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
