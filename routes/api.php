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

//Route::post('login', 'UserController@userLogin');
//Route::post('register', 'UserController@userRegister');
//Route::get('list', 'UserController@getUsers');
//Route::get('users/role/{id}', 'UserController@userByRole');
//Route::get('user/{id}', 'UserController@index');

Route::post('login', 'AuthController@login');
Route::resource('users', 'UserController');