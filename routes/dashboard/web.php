<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::prefix(env('DASH_URL'))->name(env('DASH_URL') . '.')->middleware(['auth:__tala_','web'])->group(function () {

            Route::get('index', 'HomeController@index')->name('index');
            Route::get('profile', 'HomeController@profile')->name('profile');
            Route::post('profile', 'HomeController@update_profile')->name('profile');
            Route::post('profile/password', 'HomeController@change_password')->name('profile.password');

            Route::get('settings','SettingController@index')->name('settings');
            Route::post('settings','SettingController@update')->name('settings');

            Route::resource('categories', 'Pro\CategoryController')->except(['destroy']);
            Route::get('categories/remove/{id}', 'Pro\CategoryController@remove')->name('categories.remove');

            Route::resource('products', 'Pro\ProductController')->except(['destroy']);
            Route::get('products/remove/{id}', 'Pro\ProductController@remove')->name('products.remove');

            Route::resource('product_units', 'Pro\ProductUnitController')->except(['destroy']);
            Route::get('product_units/remove/{id}', 'Pro\ProductUnitController@remove')->name('product_units.remove');

            Route::resource('cities', 'Main\CityController')->except(['destroy']);
            Route::get('cities/remove/{id}', 'Main\CityController@remove')->name('cities.remove');

            Route::resource('areas', 'Main\AreaController')->except(['destroy']);
            Route::get('areas/remove/{id}', 'Main\AreaController@remove')->name('areas.remove');

            Route::resource('locations', 'Main\LocationController')->except(['destroy']);
            Route::get('locations/remove/{id}', 'Main\LocationController@remove')->name('locations.remove');


            Route::resource('users', 'People\UserController')->except(['destroy']);
            Route::get('users/remove/{id}', 'People\UserController@remove')->name('users.remove');

            Route::resource('clients', 'People\ClientController')->except(['destroy']);
            Route::get('clients/remove/{id}', 'People\ClientController@remove')->name('clients.remove');

            Route::get('search/parents','AutocompleteController@parents')->name('search.parents');
            Route::get('search/categories','AutocompleteController@categories')->name('search.categories');
            Route::get('search/categories','AutocompleteController@categories')->name('search.categories');
            Route::get('search/cities','AutocompleteController@cities')->name('search.cities');
            Route::get('search/areas','AutocompleteController@areas')->name('search.areas');
        });
    });