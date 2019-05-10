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

Route::get('properties/search', 'PageController@search');