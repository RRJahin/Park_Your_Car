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

Route::get('/home', 'HomeController@userHome');

Route::get('/view/pplaces/{id}', 'PPlacesController@view');

Route::resource('pplaces', 'PPlacesController');

Route::get('/pspots/create/{id}', 'PSpotsController@create');

Route::post('/pspots/store', 'PSpotsController@store');

Route::resource('pspots', 'PSpotsController');

Route::get('/editProfile', 'HomeController@editProfile');

Route::match(['put', 'patch'], '/home/{home}', 'HomeController@updateProfile');