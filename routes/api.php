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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => ['api', 'xml']], function() {
    Route::post('/wevo-users', 'Api\WevoUsersController@index');
    Route::post('/wevo-users/create', 'Api\WevoUsersController@create');
    Route::post('/wevo-users/push_notification', 'Api\WevoUsersController@pushNotification');
    Route::post('/wevo-servers/create', 'Api\WevoServersController@create');
});

Route::group(['middleware' => ['api']], function() {
    Route::delete('/wevo-users/{id}/delete', 'Api\WevoUsersController@destroy');
});
