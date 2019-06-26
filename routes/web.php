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
    $session = array('status'=>true);
    return view('home')->with('session',$session);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('Home');
