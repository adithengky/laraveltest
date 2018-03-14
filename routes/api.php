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

Route::group(['prefix' => 'admin'], function() {
	//category
	Route::get('category', 'Admin\CategoryController@index');
	Route::post('category', 'Admin\CategoryController@store');
	Route::put('category/{id}', 'Admin\CategoryController@edit');
	Route::delete('category/{id}', 'Admin\CategoryController@destroy');

	//tags
	Route::get('tags', 'Admin\TagsController@index');
	Route::post('tags', 'Admin\TagsController@store');
	Route::put('tags/{id}', 'Admin\TagsController@edit');
	Route::delete('tags/{id}', 'Admin\TagsController@destroy');

	//blog
	Route::get('blogs', 'Admin\BlogController@index');
	Route::post('blogs', 'Admin\BlogController@store');
	Route::put('blogs/{id}', 'Admin\BlogController@edit');
	Route::get('blogs/{id}', 'Admin\BlogController@show');
	Route::get('tags/{id}', 'Admin\BlogController@showTag');
	Route::delete('blogs/{id}', 'Admin\BlogController@destroy');
	Route::get('archive', 'Admin\BlogController@showArchive');
	Route::get('blog/category/{id}', 'Admin\BlogController@showCategory');
	Route::get('archive/all', 'Admin\BlogController@indexArchive');

});
