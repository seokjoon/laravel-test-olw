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

Route::group(['namespace' => 'Api', 'as' => 'api.', 'middleware' => []], function() {
    Route::group(['prefix' => 'v1', 'namespace' => 'v1', 'as' => 'v1.'], function() {
        Route::get('test1', 'TestsController@test1')->name('tests.test1');
        Route::post('test1', 'TestsController@test1')->name('tests.test1');
        Route::get('test2', 'TestsController@test2')->name('tests.test2');
        Route::get('test3', 'TestsController@test3')->name('tests.test3');
    });
});
