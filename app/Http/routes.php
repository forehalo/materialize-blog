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
// Blog
Route::get('/', 'BlogController@frontIndex');

Route::get('/body/{post_id}', 'BlogController@body');
Route::resource('blog', 'BlogController');

//Archive
Route::get('categories', 'ArchiveController@groupByCategory');
Route::get('date', 'ArchiveController@groupByDate');
Route::get('tags', 'ArchiveController@groupByTag');


Route::get('/404', function(){
   return view('errors.404');
});

Route::get('back', function(){
    return view('back.index');
});


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
    //
});
