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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/property', 'PropertyController@index');
Route::get('/property/paginate', 'PropertyController@paginate');
Route::get('/property/types', 'PropertyTypeController@index');
Route::get('/listing/types', 'ListingTypeController@index');

Route::get('/amenity', 'AmenityController@index');