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

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::get('auth/user', 'AuthController@user');
Route::post('auth/logout', 'AuthController@logout');

/** @see rando */
Route::get('prize/random', 'PrizeController@random');
Route::get('prize/{prize}', 'PrizeController@get');
Route::put('prize/{type}/{prizeId}/{status}', 'PrizeController@acceptOrCancel')->where(
    [
        'type' => implode('|', \App\Prizes\Prize::PRIZE_TYPES)
    ]
);

Route::group(['middleware' => 'jwt.refresh'], function(){
	Route::get('auth/refresh', 'AuthController@refresh');
});
