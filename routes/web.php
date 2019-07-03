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

Route::get('/', 'WelcomeController@index');

Route::get('/regAsVehicle', 'WelcomeController@regAsVehicle');

Route::get('/regAsPPlace', 'WelcomeController@regAsPPlace');

Auth::routes();

Route::get('/home', 'PPlacesController@index');

Route::resource('pplaces','PPlacesController');
