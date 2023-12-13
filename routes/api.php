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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Auth routes.
Route::post('auth/login', 'Api\\AuthController@login');
Route::group(['middleware' => ['apiJwt'], 'as' => 'api.auth.'], function(){
    Route::post('auth/logout', 'Api\\AuthController@logout');
    Route::post('auth/refresh', 'Api\\AuthController@refresh');
    Route::post('auth/me', 'Api\\AuthController@me');
});

// Users routes.
Route::group(['middleware' => ['apiJwt'], 'as' => 'api.users.'], function(){ //apiJwt é um alias registrado em Kernel.php
    Route::get('users', 'Api\\UserController@index');
    Route::get('user/{id}', 'Api\\UserController@show');
    Route::post('user', 'Api\\UserController@store');
    Route::put('user/{id}', 'Api\\UserController@update');
    Route::delete('user/{id}', 'Api\\UserController@destroy');
});

// Posts routes.
Route::group(['middleware' => ['apiJwt'], 'as' => 'api.posts.'], function (){
    Route::get('posts', 'PostController@index');
    Route::get('post/{id}', 'PostController@show');
    Route::post('post', 'PostController@store');
    Route::put('post/{id}', 'PostController@update');
    Route::delete('post/{id}','PostController@destroy');
});

