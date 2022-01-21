<?php

// Home
Route::get('/', 'Home\HomeController@home')->name('home');

// Static
Route::get('/faq', 'Static\StaticPagesController@faq')->name('faq');
Route::get('/about', 'Static\StaticPagesController@about')->name('about');
Route::get('/contacts', 'Static\StaticPagesController@contact')->name('contacts');

// Events
Route::get('events', "Event\EventController@index")->name('browseEvents');
Route::get('events/create', "Event\EventController@indexCreate")->name('createEvent');
Route::post('events/create', "Event\EventController@create");
Route::get('events/{id}', "Event\EventController@get")->name('event');
Route::post('events/{id}', "Event\EventController@disable");
Route::get('events/{id}/edit', 'Event\EventController@indexEdit')->name('editEvent');
Route::post('events/{id}/edit', 'Event\EventController@update');
Route::post('events/{eventId}/join-request', 'Event\EventController@joinRequest')->name('joinRequest');
Route::post('events/{eventId}/invites/{inviteId}', 'Event\EventController@answerInvite')->name('answerInvite');
// Reports
Route::get('reports', 'Report\ReportController@index')->name('reportsDash');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('recover', 'Auth\RecoverController@showRecoverPasswordForm')->middleware('guest')->name('recoverPassword');
Route::post('recover', 'Auth\RecoverController@submitRecoverPasswordForm')->name('recoverPassword');
Route::get('reset', 'Auth\RecoverController@showResetPasswordForm')->middleware('guest')->name('password.reset');
Route::post('reset', 'Auth\RecoverController@submitResetPasswordForm')->name('password.reset');

//Users
Route::get('users', 'User\UserController@index')->name('browseUsers');
Route::get('users/{username}', 'User\UserController@show')->name('profile');
Route::post('users/{username}', 'User\UserController@block');
Route::delete('users/{username}', 'User\UserController@delete');
Route::get('users/{username}/edit', 'User\UserController@edit')->name('editProfile');
Route::post('users/{username}/edit', 'User\UserController@editUser')->name('editUser');
