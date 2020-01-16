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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('posts', 'PostsController', ['only' => ['index', 'create', 'store', 'show']]);
    Route::resource('comments', 'CommentsController', ['only' => ['store']]);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
