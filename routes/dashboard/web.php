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
            Route::post('settings','SettingController@store')->name('settings');

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
            Route::get('clients/remove/{id}', 'People\ClientController@remove')->name('clients.remove');
            Route::get('clients/invoices/{id}', 'People\ClientFunController@invoices')->name('clients.invoices');
            Route::get('clients/orders/{id}', 'People\ClientFunController@orders')->name('clients.orders');
            Route::get('clients/tasks/{id}', 'People\ClientFunController@tasks')->name('clients.tasks');
            Route::get('clients/locations/{id}', 'People\ClientFunController@locations')->name('clients.locations');
            Route::get('clients/financial/{id}', 'People\ClientFunController@financial')->name('clients.financial');

            Route::resource('admins', 'People\UserController')->except(['destroy']);
            Route::get('admins/remove/{id}', 'People\UserController@remove')->name('admins.remove');

            Route::resource('employees', 'People\EmployeeController')->except(['destroy']);
            Route::get('employees/remove/{id}', 'People\EmployeeController@remove')->name('employees.remove');
            Route::get('employee/invoices/{id}', 'People\EmployeeController@invoices')->name('employee.invoices');
            Route::get('employee/orders/{id}', 'People\EmployeeController@orders')->name('employee.orders');
            Route::get('employee/tasks/{id}', 'People\EmployeeController@tasks')->name('employee.tasks');
            Route::get('employee/locations/{id}', 'People\EmployeeController@locations')->name('employee.locations');

            Route::resource('roles', 'People\RoleController')->except(['destroy']);
            Route::get('roles/remove/{id}', 'People\RoleController@remove')->name('roles.remove');

            Route::resource('invoices', 'Functions\InvoiceController')->except(['destroy']);
            Route::get('invoices/remove/{id}', 'Functions\InvoiceController@remove')->name('invoices.remove');

            Route::resource('orders', 'Functions\OrderController')->except(['destroy']);
            Route::get('orders/remove/{id}', 'Functions\OrderController@remove')->name('orders.remove');


            Route::resource('tasks', 'Functions\TaskController')->except(['destroy']);
            Route::get('tasks/remove/{id}', 'Functions\TaskController@remove')->name('tasks.remove');

            Route::get('search/parents','AutocompleteController@parents')->name('search.parents');
            Route::get('search/categories','AutocompleteController@categories')->name('search.categories');
            Route::get('search/categories','AutocompleteController@categories')->name('search.categories');
            Route::get('search/cities','AutocompleteController@cities')->name('search.cities');
            Route::get('search/areas','AutocompleteController@areas')->name('search.areas');
            Route::get('search/clients','AutocompleteController@clients')->name('search.clients');
            Route::get('search/employees','AutocompleteController@employees')->name('search.employees');
            Route::get('search/orders','AutocompleteController@orders')->name('search.orders');
        });
    });
