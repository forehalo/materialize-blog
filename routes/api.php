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

    /*
    |--------------------------------------------------------------------------
    | Dashboard API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/statistics', 'AdminController@statistics');
    });

});
