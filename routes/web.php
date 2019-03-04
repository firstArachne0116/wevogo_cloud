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
Route::get('/', 'DashboardController@index')->name('dashboard');
Route::resource('/dashboard', 'DashboardController', ['only' => ['index', 'store']]);
Route::resource('users', 'UsersController');
Route::resource('wevo-users', 'WevoUsersController');
Route::resource('wevo-servers', 'WevoServersController');
Route::get('phonebook/sync', 'PhonebookController@sync')->name('phonebook.sync');
Route::resource('phonebook', 'PhonebookController');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
