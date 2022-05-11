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
Route::get('main/all_products', 'MainController@all_products')->name('main.all_products');
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

Route::group(['prefix' => 'emp',['middleware' => 'auth:api']], function () {
    Route::get('profile', 'Engineer\EngController@profile')->name('profile');
    Route::post('profile/edit', 'Engineer\EngController@edit')->name('profile.edit');

    Route::resource('clients', 'Emp\ClientController')->only(['index','store','show']);
    Route::post('clients/edit/{id}','Emp\ClientController@update')->name('clients.edit');
    Route::get('client_types','Emp\ClientController@types')->name('client_types');


    Route::resource('orders', 'Emp\OrderController')->only(['index','show','store']);
    Route::post('order/edit/{id}','Emp\OrderController@update')->name('order.edit');
    Route::post('order/items/create','Emp\OrderController@add_item')->name('order.items.create');
    Route::post('order/items/edit','Emp\OrderController@edit_item')->name('order.items.edit');
    Route::post('order/items/delete','Emp\OrderController@delete_item')->name('order.items.delete');
});


Route::get('temp_order', function () {
    $json[0]['product_id'] = 1;
    $json[0]['quantity'] = 10;
    ?>
    <form>
        <textarea><?php echo json_encode($json) ?></textarea>
        <input type="submit">
    </form>
    <?php
});
