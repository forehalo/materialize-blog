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
    Route::get('/foo', function () {
        return App\Models\Post::where('id', 65)->increment('favorite_count');
    });


    // Category
    Route::get('/categories', 'CategoryController@all');

    // Post
    Route::get('/posts', 'PostController@all');
    Route::get('/posts/{slug}', 'PostController@getBySlug');
    Route::post('/posts/{id}/likes', 'PostController@like');

    // Comment
    Route::get('/posts/{id}/comments', 'CommentController@getByPost');
    Route::post('/posts/{id}/comments', 'CommentController@store');
});
