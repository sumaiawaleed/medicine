<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/',function (){
   echo "sumaia";
});
Route::get('main/cities', 'MainController@cities')->name('main.cities');
Route::get('main/areas', 'MainController@areas')->name('main.areas');
Route::get('main/locations', 'MainController@locations')->name('main.locations');
Route::get('main/products', 'MainController@products')->name('main.products');
Route::get('main/categories', 'MainController@categories')->name('main.categories');

Route::post('login', 'AuthController@login')->name('login');



Route::group(['prefix' => 'client',['middleware' => 'auth:api']], function () {
    Route::get('permissions', 'Client\ProfileController@permissions')->name('permissions');
    Route::get('profile', 'Client\ProfileController@profile')->name('profile');
    Route::post('profile/edit', 'Client\ProfileController@edit')->name('profile.edit');

    Route::resource('address', 'Client\AddressController')->only(['index', 'store', 'destroy']);
    Route::post('address/update/{id}','Client\AddressController@update')->name('address.update');

    Route::resource('contacts', 'Client\ContactController')->only(['index', 'store', 'destroy']);
    Route::post('contacts/update/{id}','Client\ContactController@update')->name('contacts.update');

    Route::resource('tasks', 'Client\TaskController');


    Route::resource('orders', 'Client\OrderController');
    Route::post('order/rate','Client\OrderController@rate')->name('order.rate');
    Route::post('order/reschedule','Client\OrderController@reschedule_order')->name('order.reschedule');
    Route::post('order/cancel','Client\OrderController@cancel')->name('order.cancel');
});

Route::group(['prefix' => 'engineer', 'middleware' => ['eng_auth']], function () {
    Route::get('profile', 'Engineer\EngController@profile')->name('profile');
    Route::post('profile/edit', 'Engineer\EngController@edit')->name('profile.edit');

    Route::get('store', 'Engineer\StoreController@store')->name('store');
    Route::post('store/edit', 'Engineer\StoreController@edit')->name('store.edit');


    Route::resource('orders', 'Engineer\OrderController')->only(['index','show']);
    Route::post('order/reschedule','Engineer\OrderController@reschedule_order')->name('order.reschedule');
    Route::post('order/status/{id}','Engineer\OrderController@update')->name('order.status');
});


Route::get('temp_order', function () {
    $json['details'][0]['model_id'] = 1;
    $json['details'][0]['color_id'] = 1;
    $json['details'][0]['service_id'] = 1;
    $json['details'][0]['brand_id'] = 6;

    foreach (json_decode(json_encode($json['details']),TRUE) as $index=>$j){
        echo $j['model_id'];
        echo "<br>";
        return;
    };
});
