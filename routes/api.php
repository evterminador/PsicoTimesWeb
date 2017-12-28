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

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');

Route::prefix('post')->group(function () {
    Route::post('profile', 'Api\PostController@createProfile');
    Route::get('fetch/app', 'Api\PostController@getAppAll');
    Route::post('state/user', 'Api\PostController@putAll');
    Route::post('state/historic', 'Api\PostController@putHistoric');
});

Route::get('application', 'Api\PostController@test');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
