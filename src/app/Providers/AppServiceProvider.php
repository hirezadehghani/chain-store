<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // in some ServiceProvider, AppServiceProvider for example
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class, //this is package controller
            \App\Http\Controllers\Admin\EmployeeCrudController::class //this should be your own controller
        );

        // this tells Laravel that when UserCrudController is requested, your own UserCrudController should be served.
    }
}
