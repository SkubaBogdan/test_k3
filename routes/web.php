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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('register', 'RegistrationController@register');
Route::post('register', 'RegistrationController@postRegister');

Route::get('register/confirm/{token}', 'RegistrationController@confirmEmail');

Route::get('login', 'SessionsController@login')->middleware('guest');
Route::post('login', 'SessionsController@postLogin')->middleware('guest');
Route::get('logout', 'SessionsController@logout');

Route::get('dashboard', ['middleware' => 'auth', function() {
    return 'Добро пожаловать, '.Auth::user()->name.'!';
}]);
