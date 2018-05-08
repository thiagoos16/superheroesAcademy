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

Route::group(['prefix' => 'superpower'], function () {
    Route::get('/', 'SuperpowerController@index');
    Route::post('/create', 'SuperpowerController@create');
    Route::get('/edit/{id}', 'SuperpowerController@viewEdit');
    Route::post('/edit', 'SuperpowerController@edit');
    Route::get('/delete/{id}', 'SuperpowerController@delete');
});
