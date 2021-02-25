<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'UsersController@login');
Route::post('signup', 'UsersController@signup');
Route::get('logout', 'UsersController@logout');
Route::post('register', "UsersController@register");

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', 'UsersController@user');
    Route::put("update/{id}", "UsersController@update");
    Route::get("sold", "UsersController@sold");

    Route::resource('reviews', 'ReviewController');
    Route::resource('drivers', 'DriverController');
    Route::post('drivers/find', "DriverController@find");
    Route::post("driver/command", "DriverController@command");

    Route::get("rides/all", "RidesController@getAllDriverRides");
    Route::get("rides/client/all", "RidesController@getAllClientRides");
	Route::get("rides/types", "RidesController@getTypes");
	Route::resource("rides", "RidesController");
    Route::post("rides/bydistance", "RidesController@getRidesByDistance");
    Route::put("rides/accept/{id}", "RidesController@acceptRide");
    Route::get("/rides/{ride_id}/terminate", "RidesController@terminate");
    Route::get("/rides/{ride_id}/notify/client", "RidesController@notifyClient");

    Route::post("users/{id}/token/register", "UsersController@registerToken");
    Route::put("users/token/update", "UsersController@updateToken");
});
