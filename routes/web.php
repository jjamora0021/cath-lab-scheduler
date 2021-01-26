<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
	return redirect('/login');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/calendar', 'CalendarController@index')->name('calendar');

Route::get('/request-schedule', 'CalendarController@request')->name('request-schedule');
Route::post('/create-request-schedule', 'CalendarController@createRequestSchedule')->name('create-request-schedule');
Route::get('/check-schedule', 'CalendarController@checkSchedule')->name('check-schedule');
Route::get('/fetch-schedule-info', 'CalendarController@fetchScheduleInfo')->name('check-schedule-info');
Route::put('/update-schedule', 'CalendarController@updateScheduleInfo')->name('update-schedule');
