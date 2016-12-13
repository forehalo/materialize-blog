<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// index
Route::get('/', 'Controller@index');

// dashboard
Route::get('/dashboard', 'Controller@dashboard');

// captcha
Route::get('/captcha', 'Controller@captcha');


Route::any('/dashboard/{any}', 'Controller@dashboard')->where('any', '.*');
// Must be placed below other routes.
Route::any('/{any}', 'Controller@index')->where('any', '.*');
