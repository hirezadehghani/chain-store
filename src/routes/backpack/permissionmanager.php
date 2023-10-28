<?php

/*
|--------------------------------------------------------------------------
| Backpack\PermissionManager Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\PermissionManager package.
|
*/

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace'  => 'Backpack\PermissionManager\app\Http\Controllers',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::group(['middleware' => ['can:permissions.see']], function () {  // <<--  Added this line
        Route::crud('permission', 'PermissionCrudController');
    });
    Route::group(['middleware' => ['can:roles.see']], function () {  // <<--  Added this line
        Route::crud('role', 'RoleCrudController');
    });
});
