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
Route::get('events/{id}/attendees', "Event\EventApiController@getAttendees");
Route::post('events/{eventId}/attendees', "Event\EventApiController@attendEventClick")->name('attendEventClick');
Route::delete('events/{eventId}/attendees', "Event\EventApiController@leaveEventClick")->name('leaveEventClick');
Route::post('events/{eventId}/invites', 'Event\EventApiController@invite');
Route::get('events/{eventId}/invites', 'Event\EventApiController@getInvites');
Route::get('events/{eventId}/invites', 'Event\EventApiController@getInvites');
Route::get('events/{eventId}/comments', 'Event\EventApiController@getComments')->name('getComments');
Route::post('events/{eventId}/comments', 'Event\EventApiController@submitComment')->name('submitComment');

// Reports
// Route::post('reports/event', 'Report\ReportAPIController@reportEvent')->name('report');
// Route::post('reports/user', 'ReportAPIController@reportUser');
// Route::post('reports/comment', 'Report\ReportAPIController@reportComment');
// Route::get('reports', 'Report\ReportAPIController@getReports');
// Route::get('reports/{report_id}', 'Report\ReportAPIController@show');
