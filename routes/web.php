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
Route::delete('events/{id}', 'Event\EventController@delete');
Route::get('events/{id}/edit', 'Event\EventController@indexEdit')->name('editEvent');
Route::post('events/{id}/edit', 'Event\EventController@update');
Route::get('test', function () {
    event(new App\Events\NotificationReceived('teste'));
    return "Event has been sent!";
});

// Reports
Route::get('reports', 'Report\ReportController@index')->name('reportsDash');
// Route::get('reports/{report_id}', 'Report\ReportController@show');
// Route::post('reports/{report_id}', 'Report\ReportController@execute');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


//Users
Route::get('users', 'User\UserController@index')->name('browseUsers');
Route::get('users/{username}', 'User\UserController@show')->name('profile');
Route::post('users/{username}', 'User\UserController@block');
Route::delete('users/{username}', 'User\UserController@delete');
Route::get('users/{username}/edit', 'User\UserController@edit')->name('editProfile');
Route::post('users/{username}/edit', 'User\UserController@editUser')->name('editUser');

//Notifications
Route::get('api/notifications', 'Notifications\NotificationController@get')->name('notifications');
Route::get('api/notifications/past', 'Notifications\NotificationController@getPast')->name('pastNotifications');
Route::post('api/notifications/read', 'Notifications\NotificationController@read')->name('readNotifications');
Route::post('api/notifications/{id}', 'Notifications\NotificationController@edit')->name('editNotifcation');
Route::delete('api/notifications/{id}', 'Notifications\NotificationController@delete');
