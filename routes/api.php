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
Route::get('events/{eventId}/comments/count', 'Event\EventApiController@getCommentsCount')->name('getCommentsCount');
Route::post('events/{eventId}/comments', 'Event\EventApiController@submitComment')->name('createComment');
Route::delete('events/{eventId}/comments/{commentId}', 'Event\EventApiController@deleteComment')->name('deleteComment');
Route::get('events/{eventId}/comments/{commentId}', 'Event\EventApiController@getComment')->name('getComment');
Route::post('events/{eventId}/join-requests/{requestId}', 'Event\EventApiController@answerJoinRequest');
Route::post('events/{eventId}/polls/{pollId}/{pollOption}', 'Event\EventApiController@addVote')->name('addVote');
Route::delete('events/{eventId}/polls/{pollId}/{pollOption}', 'Event\EventApiController@removeVote')->name('removeVote');
Route::post('events/{eventId}/polls', 'Event\EventApiController@submitPoll')->name('createPoll');
Route::get('events/{eventId}/polls', 'Event\EventApiController@getPolls')->name('getPolls');
Route::get('events/{eventId}/polls/{pollId}', 'Event\EventApiController@getPoll')->name('getPoll');
Route::post('events/{eventId}/polls/{pollId}', 'Event\EventApiController@switchPollState')->name('switchPollState');
Route::delete('events/{eventId}/polls/{pollId}', 'Event\EventApiController@removePoll')->name('removePoll');


// Reports
Route::get('reports/form', 'Report\ReportAPIController@getForm')->name('registerReport');
Route::post('reports/{reportId}/mark-handled', 'Report\ReportAPIController@markHandled');
Route::post('reports/{reportId}/block', 'Report\ReportAPIController@block');
Route::post('reports/{reportId}/delete', 'Report\ReportAPIController@delete');
Route::post('reports/{type}/{id}', 'Report\ReportAPIController@registerReport');

// Route::post('reports/user', 'ReportAPIController@reportUser');
// Route::post('reports/comment', 'Report\ReportAPIController@reportComment');
// Route::get('reports', 'Report\ReportAPIController@getReports');
// Route::get('reports/{report_id}', 'Report\ReportAPIController@show');

//Notifications
Route::get('notifications', 'Notifications\NotificationController@get')->name('notifications');
Route::get('notifications/past', 'Notifications\NotificationController@getPast')->name('pastNotifications');
Route::post('notifications/read', 'Notifications\NotificationController@read')->name('readNotifications');
Route::post('notifications/{id}', 'Notifications\NotificationController@edit')->name('editNotifcation');
Route::delete('notifications/{id}', 'Notifications\NotificationController@delete');
