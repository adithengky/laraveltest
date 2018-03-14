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

Route::get('/', 'Client\HomeController@index');
Route::get('/tags', 'Client\HomeController@indexTags');
Route::get('blog/{id}', 'Client\HomeController@detail');
Route::get('category/{id}', 'Client\HomeController@indexByCategory');
Route::get('addPost', 'Client\HomeController@showPost');
Route::get('archive/{id}', 'Client\HomeController@indexArchive');
Route::post('blog', 'Client\HomeController@storeBlog');
