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
Route::get('properties/post', 'PropertyController@create')->middleware("auth");
Route::get('properties/search', 'PageController@search');
Route::get('properties/view/{property}', 'PropertyController@view');
Route::get('properties/update/{property}', 'PropertyController@update')->middleware("auth");
Route::get('properties/toggleArchive/{property}', 'PropertyController@toggleArchive')->middleware("auth");
Route::post('properties/post', 'PropertyController@store')->middleware("auth");

// Users
Route::get('users', 'UserController@index');
Route::post('users/update/{user}', 'UserController@update');
Route::post('users/update/email/{user}', 'UserController@update_email');
Route::post('users/update/password/{user}', 'UserController@update_password');
Route::post('users/email/resend/{user}', 'UserController@resend_verification');
Route::get('users/view/{user}', 'UserController@index');
Route::get('users/destroy/{user}', 'UserController@destroy');
Route::post('users/check_deactivated', 'UserController@is_deactivated');
Route::get('users/reactivate', 'UserController@show_reactivate');
Route::post('users/reactivate', 'UserController@reactivate');

// Auth Routes
Auth::routes(["verify" => true]);   
Route::get('login', 'PageController@invalid')->name("login");
Route::get('register', 'PageController@invalid');
Route::get('password/reset', 'PageController@invalid');
Route::get('logout', 'PageController@logout');
