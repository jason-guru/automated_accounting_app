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

Route::group(['namespace' => 'Backend\Api'], function () {
    Route::get('/deadline/aa-cs', 'DeadlineController@aaCs');
    Route::get('/deadline/vat', 'DeadlineController@vat');
    Route::get('/deadline/paye-cis', 'DeadlineController@payeCis');
});

