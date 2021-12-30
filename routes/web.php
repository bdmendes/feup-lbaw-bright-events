<?php

// Home
Route::get('/', 'Home\HomeController@home')->name('home');

// Static
Route::get('/faq', 'Static\StaticPagesController@faq');
Route::get('/about', 'Static\StaticPagesController@about');
Route::get('/contact', 'Static\StaticPagesController@contact');

// Events
Route::get('events', "Event\EventController@index")->name('browseEvents');
Route::get('events/create', "Event\EventController@indexCreate")->name('createEvent');
Route::post('events/create', "Event\EventController@create")->name('createEvent');
Route::get('events/{id}', "Event\EventController@get")->name('event');
Route::get('events/{id}/edit', 'Event\EventController@indexEdit')->name('editEvent');
// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Users
Route::get('users/{username}', 'User\UserController@show')->name('profile');
Route::get('users/{username}/edit', 'User\UserController@edit')->name('editProfile');
Route::post('users/{username}/edit', 'User\UserController@editUser')->name('editUser');
