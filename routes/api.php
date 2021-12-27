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

// Middleware
Route::middleware('auth:api')->get('/user', 'Auth\LoginController@getUser');

// Events
Route::get('events', "EventApiController@index");
Route::patch('events/{id}', "EventApiController@update");
Route::get('events/{id}/attendees', "EventApiController@getAttendees");
Route::get('events/{id}/comments', "EventApiController@getComments");
