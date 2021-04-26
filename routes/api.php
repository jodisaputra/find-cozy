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

Route::get('boardinghouse', 'API\BoardingHouseController@index')->middleware('auth:api');
Route::post('boardinghouse', 'API\BoardingHouseController@store')->middleware('auth:api');
Route::put('boardinghouse/{boardinghouse_id}', 'API\BoardingHouseController@update')->middleware('auth:api');
Route::delete('boardinghouse/{boardinghouse_id}', 'API\BoardingHouseController@destroy')->middleware('auth:api');
