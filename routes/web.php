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

Route::get('/', "HomeController@index")->name("login");
Route::get('asher', "UsersController@asher")->name("asher");
Route::post("login", "Site\UsersController@login")->name("dologin");

Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Site\RegistrationController@confirm'
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', "HomeController@home")->name("home");
    Route::resource('drivers', 'Site\DriverController');
    Route::get('/drivers/toggle/{id}', "Site\DriverController@toggle")->name("drivers.toggle");

    Route::resource("ridetypes", "Site\RideTypesController");
});
Route::resource('users', 'Site\UsersController');

Route::get("logout", "Site\UsersController@logout")->name("logout");
