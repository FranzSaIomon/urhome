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

// Generic Page Routs
Route::get('/', "PageController@index");
Route::get('about', 'PageController@about');
Route::get('contact', 'PageController@contact');

// Properties
Route::get('properties', 'PageController@search');
Route::get('properties/search', 'PageController@search');
Route::get('properties/view/{property}', 'PropertyController@view');
Route::get('properties/update/{property}', 'PropertyController@update');
Route::get('properties/toggleArchive/{property}', 'PropertyController@toggleArchive')->middleware("auth");

// Users
Route::get('users', 'UserController@index');
Route::get('users/view/{user}', 'UserController@index');

// Auth Routes
Auth::routes(["verify" => true]);   
Route::get('login', 'PageController@invalid')->name("login");
Route::get('register', 'PageController@invalid');
Route::get('password/reset', 'PageController@invalid');
Route::get('logout', 'PageController@logout');
