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
Route::post('events/create', "Event\EventController@create")->name('createEvent');
Route::get('events/{id}', "Event\EventController@get")->name('event');
Route::get('events/{id}/edit', 'Event\EventController@indexEdit')->name('editEvent');
Route::post('events/{id}/edit', 'Event\EventController@update')->name('editEvent');

// Reports
Route::get('reports', 'Report\ReportController@index')->name('reports');
Route::get('reports/{report_id}', 'Report\ReportController@show');
Route::post('reports/{report_id}', 'Report\ReportController@execute');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');


//Users
Route::get('users', 'User\UserController@index')->name('browseUsers');
Route::get('users/{username}', 'User\UserController@show')->name('profile');
Route::get('users/{username}/edit', 'User\UserController@edit')->name('editProfile');
Route::post('users/{username}/edit', 'User\UserController@editUser')->name('editUser');
