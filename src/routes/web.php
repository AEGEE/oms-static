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

Route::get('static/discounts', function () {
    //This might be a bit of a hack, and not really the laravel way...
    //But I do not know of another way to simply serve a php file
    dump("DISCOUNTS!!!");
    include public_path() . '/static/discounts/index.php';
})->middleware('auth');//->name('home');


/**
 * Register the typical authentication routes for an application.
 *
 * Normally done by Auth::routes()
 * From Illuminate\Routing\Router.php
 *
 * @return void
*/
// Authentication Routes...
Route::get('static/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('static/login', 'Auth\LoginController@login');
Route::post('static/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('static/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('static/register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('static/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('static/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('static/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('static/password/reset', 'Auth\ResetPasswordController@reset');
