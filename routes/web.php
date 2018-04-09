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

Route::get('/', 'Web\PageController@home')->name('home');
Route::get('/login', 'Web\PageController@login')->name('login');
Route::get('/register', 'Web\PageController@register')->name('register');
Route::get('/register/confirmation/{code}', 'Auth\AuthController@confirmation')->name('confirmation');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@resetPasswordForm')->name('password.reset');
Route::get('/password/reset', 'Auth\ForgotPasswordController@linkRequestForm')->name('password.request');

Route::post('login', 'Auth\AuthController@login');
Route::post('register', 'Auth\RegisterController@register');
Route::post('login-facebook', 'Auth\AuthController@loginFacebook');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', 'Web\PageController@dashboard')->name('dashboard');

    Route::get('/users/search', 'Web\UserController@search');
    Route::get('/users/{id}', 'Web\UserController@show')->name('user.show');
    Route::get('/users', 'Web\UserController@index')->name('user.index');
    Route::post('users', 'Web\UserController@store');
    Route::put('users/{id}', 'Web\UserController@update');
    Route::delete('users/{id}', 'Web\UserController@delete');
    Route::post('users/avatar-upload', 'Web\UserController@avatarUpload');

    Route::get('/contacts/search', 'Web\ContactController@search');
    Route::get('/contacts/{id}', 'Web\ContactController@show')->name('contact.show');
    Route::get('/contacts', 'Web\ContactController@index')->name('contact.index');
    Route::post('contacts', 'Web\ContactController@store');
    Route::put('contacts/{id}', 'Web\ContactController@update');
    Route::delete('contacts/{id}', 'Web\ContactController@delete');
    Route::post('/contacts/{id}/file-upload', 'Web\ContactController@fileUpload');

    Route::delete('assets/{id}', 'Web\AssetController@delete');

    Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

});


