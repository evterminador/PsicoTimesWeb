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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});

Route::prefix('user')->group(function () {
   Route::get('/', 'AdminController@listUser')->name('list.user');
});

Route::prefix('admin/application')->group(function () {
    Route::get('/delete/{application}', 'ApplicationController@destroy')->name('application.delete');
    Route::get('/edit/{application}', 'ApplicationController@edit')->name('application.edit');
    Route::post('/', 'ApplicationController@store')->name('application.submit');
    Route::get('/', 'ApplicationController@index')->name('application.index');
});

Route::get('/home', 'HomeController@index')->name('home');
