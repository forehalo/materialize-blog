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
    Route::resource('posts', 'BlogController');

    Route::get('body/{id}', 'BlogController@body');

    //Archive
    Route::get('categories', 'ArchiveController@groupByCategory');
    Route::get('categories/{id}', 'ArchiveController@showCategory');
    Route::get('date', 'ArchiveController@groupByDate');
    Route::get('tags', 'ArchiveController@groupByTag');

    // Comment
    Route::resource('comments', 'CommentController', [
        'except' => ['create', 'show']
    ]);


    Route::get('404', function () {
        return view('errors.404');
    });

    Route::get('back', function () {
        return view('back.index');
    });
});
