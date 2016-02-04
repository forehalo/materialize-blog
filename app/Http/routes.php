<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    // Blog
    Route::get('/', 'BlogController@frontIndex');
    Route::get('posts', 'BlogController@normalIndex');
    Route::get('posts/{id}/comments', 'BlogController@comments');
    Route::resource('posts', 'BlogController', [
        'except' => ['index']
    ]);
    Route::put('posts/{id}/favorite', 'BlogController@favorite');
    Route::get('body/{id}', 'BlogController@body');

    //Archive
    Route::get('categories', 'ArchiveController@groupByCategory');
    Route::get('categories/{id}', 'ArchiveController@showCategory');
    Route::get('date', 'ArchiveController@groupByDate');
    Route::get('tags', 'ArchiveController@groupByTag');
    Route::get('tags/{id}', 'ArchiveController@showTag');

    // Comment
    Route::resource('comments', 'CommentController', [
        'except' => ['create', 'show']
    ]);


    // Authentication
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
    });

    // Dashboard
    Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard', function () {
            return view('back.index');
        });
        Route::get('logout', 'Auth\AuthController@getLogout');
    });


    Route::get('404', function () {
        return view('errors.404');
    });
});