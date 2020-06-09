<?php

/*
|--------------------------------------------------------------------------
| Service - API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for this service.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Prefix: /api/api
Route::group(['prefix' => 'api'], function() {

    // The controllers live in src/Services/Api/Http/Controllers
    // Route::get('/', 'UserController@index');

    Route::get('/', function() {
        return response()->json(['path' => '/api/api']);
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('sociallogin/{provider}', '\App\Services\Api\Http\Controllers\AuthController@SocialSignup');
    Route::get('auth/{provider}/callback', '\App\Services\Api\Http\Controllers\OutController@index')->where('provider', '.*');

});
