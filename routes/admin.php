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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum', 'role:super-admin']], function (){

    Route::get('companies-all', 'CompanyController@all');
    Route::post('logout', 'AuthController@logout');
    Route::put('companies', 'CompanyController@updateOrCreate');
    Route::apiResource('companies', 'CompanyController');

    //users
    Route::put('users', 'UserController@updateOrCreate');
    Route::apiResource('users', 'UserController');

});

Route::post('login', 'AuthController@login');