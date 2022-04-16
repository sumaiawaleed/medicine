<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('clear-compiled');
    //$exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {

        Auth::routes(['login' => false, 'register' => 'false']);

        Route::get(env('DASH_URL') . '/login', [\App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])
            ->name(env('DASH_URL') . '/login');

        Route::post(env('DASH_URL') . '/loginProcess', [\App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])
            ->name(env('DASH_URL') . '.loginProcess');

        Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
