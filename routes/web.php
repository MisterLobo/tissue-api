<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('sociallogin/{provider}', '\App\Services\Api\Http\Controllers\AuthController@SocialSignup');
Route::get('auth/{provider}/callback', '\App\Services\Api\Http\Controllers\OutController@index')->where('provider', '.*');
Route::post('social/getuser/{provider}', '\App\Services\Api\Http\Controllers\AuthController@getUserFromSession');
//Route::middleware('auth:sanctum')->post('login', '\App\Services\Api\Http\Controllers\AuthController@index')->name('login');
// Route::middleware('auth:sanctum')->post('upload', '\App\Services\Api\Http\Controllers\UploadController@index');
