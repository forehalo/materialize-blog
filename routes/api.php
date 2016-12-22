<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {

    // Category
    Route::get('/categories', 'ArchiveController@categories');
    Route::get('/categories/{name}/posts', 'ArchiveController@getPostsByCategory');

    // Tag
    Route::get('/tags', 'ArchiveController@tags');
    Route::get('/tags/{name}/posts', 'ArchiveController@getPostsByTag');

    // Date
    Route::get('/dates', 'ArchiveController@getExistDates');
    Route::get('/dates/{date}/posts', 'ArchiveController@getPostsByDate');

    // Post
    Route::get('/posts', 'PostController@all');
    Route::get('/posts/{slug}', 'PostController@getBySlug');
    Route::post('/posts/{id}/likes', 'PostController@like');

    // Comment
    Route::get('/posts/{id}/comments', 'CommentController@getByPost');
    Route::post('/posts/{id}/comments', 'CommentController@store');

    // Others
    Route::get('/links', 'SettingController@links');
    Route::get('/pages/{name}', 'PageController@page');

    /*
    |--------------------------------------------------------------------------
    | Dashboard API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth'], 'prefix' => 'dashboard'], function () {
        Route::get('/statistics', 'AdminController@statistics');

        // Post
        Route::get('/posts', 'PostController@manage');
        Route::post('/posts', 'PostController@store');
        Route::get('/posts/{id}', 'PostController@getOrigin');
        Route::put('/posts/{id}', 'PostController@update');
        Route::put('/posts/{id}/publish', 'PostController@publish');
        Route::delete('/posts/{id}', 'PostController@destroy');

        // Comment
        Route::get('/comments', 'CommentController@manage');
        Route::put('/comments/{id}/valid', 'CommentController@valid');
        Route::put('/comments/{id}/seen', 'CommentController@seen');
        Route::delete('/comments/{id}', 'CommentController@destroy');

        // Setting
        Route::post('/settings/links', 'SettingController@storeLink');
        Route::put('/settings/links/{id}', 'SettingController@updateLink');
        Route::delete('/settings/links/{id}', 'SettingController@destroyLink');
        Route::get('/settings/auth', 'SettingController@auth');
        Route::put('/settings/auth', 'SettingController@updateAuth');
    });
});
