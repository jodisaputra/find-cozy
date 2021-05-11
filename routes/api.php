<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('/register', 'API\LoginController@register');
    Route::post('/login', 'API\LoginController@login');

    Route::get('/logout', 'API\LoginController@logout')->middleware('auth:api');
    Route::get('/user', 'API\LoginController@user')->middleware('auth:api');
    Route::post('/profile', 'API\LoginController@updateprofile')->middleware('auth:api');
    Route::post('/profilephoto', 'API\LoginController@updatephoto')->middleware('auth:api');
});

//boarding house user
Route::get('boardinghouse', 'API\BoardingHouseController@index');
Route::post('boardinghouse', 'API\BoardingHouseController@store')->middleware('auth:api');
Route::put('boardinghouse/{boardinghouse_id}', 'API\BoardingHouseController@update')->middleware('auth:api');
Route::delete('boardinghouse/{boardinghouse_id}', 'API\BoardingHouseController@destroy')->middleware('auth:api');

//boarding house admin

//boarding room
Route::get('boardingroom/{boardinghouse_id}', 'API\BoardingRoomController@index')->middleware('auth:api');
Route::post('boardingroom/{boardinghouse_id}', 'API\BoardingRoomController@store')->middleware('auth:api');
Route::put('boardingroom/{boardingroom_id}', 'API\BoardingRoomController@update')->middleware('auth:api');
Route::delete('boardingroom/{boardingroom_id}', 'API\BoardingRoomController@destroy')->middleware('auth:api');

//boarding image
Route::get('boardinghouseimage/{boardinghouse_id}', 'API\BoardingHouseImageController@index')->middleware('auth:api');
Route::post('boardinghouseimage/{boardinghouse_id}', 'API\BoardingHouseImageController@store')->middleware('auth:api');
Route::post('boardinghouseimageupdate/{boardingroom_id}', 'API\BoardingHouseImageController@update')->middleware('auth:api');
Route::delete('boardinghouseimage/{boardingroom_id}', 'API\BoardingHouseImageController@destroy')->middleware('auth:api');

// Favorite user
Route::get('favorite', 'API\FavoritesController@index')->middleware('auth:api');
Route::post('favorite/{favorite_id}', 'API\FavoritesController@store')->middleware('auth:api');
Route::delete('favorite/{favorite_id}', 'API\FavoritesController@destroy')->middleware('auth:api');

// Favorite user
Route::get('review', 'API\ReviewController@index')->middleware('auth:api');
Route::post('review/{review_id}', 'API\ReviewController@store')->middleware('auth:api');
Route::delete('review/{review_id}', 'API\ReviewController@destroy')->middleware('auth:api');
