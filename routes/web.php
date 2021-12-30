<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home
Route::get('/', 'Home\HomeController@redirect');
Route::get('/home', 'Home\HomeController@home')->name('home');

//Static
Route::get('/faq', 'Static\StaticPagesController@faq');
Route::get('/about', 'Static\StaticPagesController@about');
Route::get('/contact', 'Static\StaticPagesController@contact');

//Events
Route::get('events', "Event\EventController@index")->name('browseEvents');
Route::get('events/create', "Event\EventController@indexCreate")->name('createEvent');
Route::post('events/create', "Event\EventController@create")->name('createEvent');
Route::get('events/{id}', "Event\EventController@get")->name('event');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
