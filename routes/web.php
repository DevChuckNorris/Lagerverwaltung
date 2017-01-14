<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/storage', 'StorageController@index');
Route::get('/storage/{id}/edit', 'StorageController@edit');
Route::post('/storage/{id}/edit', 'StorageController@editPost');
Route::get('/storage/{id}/delete', 'StorageController@delete');
Route::get('/storage/new', 'StorageController@newStorage');
Route::get('/storage/{parent}/new/', 'StorageController@newStorageParent');

Route::get('/components', 'ComponentController@listComponents');
Route::get('/component/{id}', 'ComponentController@view');
Route::post('/component/{id}', 'ComponentController@save');
Route::get('/component/{id}/quantity/{quantity}', 'ComponentController@updateQuantity');
Route::get('/component/storage/children/{id}', 'ComponentController@storageChildren');