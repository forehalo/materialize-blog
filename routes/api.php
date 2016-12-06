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
    Route::get('/categories', 'CategoryController@all');

    // Post
    Route::get('/posts', 'PostController@all');
    Route::get('/posts/{slug}', 'PostController@getBySlug');

    // Comment
    Route::get('/posts/{id}/comments', 'CommentController@getByPost');
    Route::post('/posts/{id}/comments', 'CommentController@store');
});
