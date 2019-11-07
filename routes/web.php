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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function(){
    return view('admin.index');
});

//---MXV, group to use middleware
/* Route::group(['middleware' => 'admin'], function(){
    Route::resource('admin/users', 'AdminUsersController');
}); */

//---MXV: Code above is the good one, workaround below
//---MXV add routes from exercise
Route::name('admin.')->group(function(){
    Route::resource('admin/users', 'AdminUsersController');
});

//---MXV Change from the original one in the videos
Route::resource('admin/posts', 'AdminPostsController', ['names'=>[
    'index' => 'admin.posts.index',
    'create' => 'admin.posts.create',
    'store' => 'admin.posts.store',
    'edit' => 'admin.posts.edit',
]]);

