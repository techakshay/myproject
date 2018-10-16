<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('food/create', 'FoodController@create');
//Route::get('food/store', 'FoodController@store');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/food', 'FoodController@store')->name('food.store');
Route::get('/food/address', 'FoodController@address')->name('food.address');
Route::post('/address/store', 'FoodController@address_store')->name('address.store');
Route::get('/thankyou', 'FoodController@thankyou')->name('thankyou');
Route::get('/animation', 'FunController@animation')->name('thankyou');
