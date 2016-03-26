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
    // Index
    Route::get('/', 'BlogController@frontIndex');
    // Normal Index
    Route::get('posts', 'BlogController@normalIndex');
    // Search
    Route::get('search', 'BlogController@search');

    // Authentication
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
    });

    // Dashboard
    Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard', 'AdminController@index');
        // Posts admin
        Route::get('posts/admin', 'BlogController@backIndex');
        Route::put('posts/{id}/publish', 'BlogController@publish');
        Route::get('posts/file', 'BlogController@getUpload');
        Route::post('posts/upload', 'BlogController@upload');
        // Comments admin
        Route::put('comments/{id}/valid', 'CommentController@valid');
        Route::put('comments/{id}/seen', 'CommentController@seen');
        // Settings admin
        Route::get('settings', 'AdminController@setting');
        Route::post('settings/profile', 'AdminController@profile');
        Route::post('settings/view', 'AdminController@view');
        Route::post('settings/link', 'AdminController@link');
        Route::post('settings/friend', 'AdminController@friend');
        Route::post('settings/auth', 'AdminController@auth');

        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    // Blog
    Route::get('posts/{id}/comments', 'BlogController@comments');
    Route::resource('posts', 'BlogController', [
        'except' => 'index'
    ]);
    Route::put('posts/{id}/favorite', 'BlogController@favorite');
    Route::get('posts/{id}/body', 'BlogController@body');

    //Archive
    Route::get('categories', 'ArchiveController@groupByCategory');
    Route::get('categories/{id}', 'ArchiveController@showCategory');
    Route::get('date', 'ArchiveController@groupByDate');
    Route::get('tags', 'ArchiveController@groupByTag');
    Route::get('tags/{id}', 'ArchiveController@showTag');

    // Comment
    Route::resource('comments', 'CommentController', [
        'except' => ['create', 'show', 'edit','update']
    ]);

    // Captcha
    Route::get('captcha', 'Controller@captcha');
    // Sitemap
    Route::get('sitemap', 'Controller@sitemap');
    Route::get('about', 'Controller@about');



    Route::get('404', function () {
        return view('errors.404');
    });

    Route::get('foo', function(){
        
    });
});