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

Route::post('auth/login', 'Api\\AuthController@login');

Route::group(['middleware' => ['apiJwt']], function(){ //apiJwt é um alias registrado em Kernel.php
    Route::get('users', 'Api\\UserController@index');
    Route::post('logout', 'Api\\AuthController@logout');
    Route::post('refresh', 'Api\\AuthController@refresh');
    Route::post('me', 'Api\\AuthController@me');
});


Route::post('user', 'Api\\UserController@store');

//As rotas em api são prefixadas com /api por padrão
Route::get('posts', 'PostController@index');
Route::get('post/{id}', 'PostController@show');
Route::post('post', 'PostController@store');
Route::put('post/{id}', 'PostController@update');
Route::delete('post/{id}','PostController@destroy');
