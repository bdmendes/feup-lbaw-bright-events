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
/* Route::get('events', "Event\EventApiController@index");
Route::patch('events/{id}', "Event\EventApiController@update"); */
Route::get('events/{id}/attendees', "Event\EventApiController@getAttendees");
Route::get('events/{id}/comments', "Event\EventApiController@getComments");
Route::post('events/{eventId}/attendees', "Event\EventApiController@addAttendee")->name('addAttendee');
Route::delete('events/{eventId}/attendees', "Event\EventApiController@removeAttendee")->name('removeAttendee');

// Reports
// Route::post('reports/event', 'Report\ReportAPIController@reportEvent')->name('report');
// Route::post('reports/user', 'ReportAPIController@reportUser');
// Route::post('reports/comment', 'Report\ReportAPIController@reportComment');
// Route::get('reports', 'Report\ReportAPIController@getReports');
// Route::get('reports/{report_id}', 'Report\ReportAPIController@show');
