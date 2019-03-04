<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        app('view')->composer('layout.admin', function ($view) {
            $action = app('request')->route()->getAction();
            if (array_key_exists('controller', $action)) {
                $controller = class_basename($action['controller']);
                list($controller, $action) = explode('@', $controller);
            } else $controller = 'unknown';

            $view->with(compact('controller', 'action'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
