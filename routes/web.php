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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', 'PostController@index');
Route::get('post/', 'PostController@index')->name('post.index');
Route::get('post/create', 'PostController@create')->name('post.create');
Route::get('post/show/{id}', 'PostController@show')->name('post.show');
Route::get('post/edit/{id}', 'PostController@edit')->name('post.edit');
Route::post('comment/store', 'PostController@comment')->name('comment.store');
Route::post('post/store', 'PostController@store')->name('post.store');
Route::patch('post/show/{id}', 'PostController@update')->name('post.update');
Route::delete('post/{id}', 'PostController@destroy')->name('post.destroy');
Route::delete('comment/{id}', 'PostController@destroycomment')->name('comment.destroy');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

