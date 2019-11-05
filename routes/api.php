<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiCalcController;

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


Route::post('calculate', 'ApiCalcController@calculate');
Route::post('coordinates', 'ApiGeoController@coordinates');
Route::post('tracking', 'ApiTrackingController@tracking');
