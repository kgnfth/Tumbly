<?php

use Illuminate\Support\Facades\Route;

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

Route::get('flush', function () {
    session()->flush();
    return redirect('/');
})->name('logout');

Route::group(['middleware' => 'has.token'], function () {
    Route::view('/', 'welcome')->name('welcome');
});

Route::get('/auth/tumblr', 'Auth\TumblrLoginController@auth')->name('tumblr.auth');
Route::get('/auth/tumblr/callback', 'Auth\TumblrLoginController@callback');

Route::group(['middleware' => 'tumblr'], function () {
    Route::get('/home/{type?}', 'HomeController@index')->name('home');
    Route::get('/post/{blog}/{id}/{slug?}', 'HomeController@show')->name('post');
    Route::get('/tagged/{tag}', 'HomeController@search')->name('tag');

    Route::get('/create', 'UserController@createPost')->name('create');

    Route::get('/likes', 'UserController@likes')->name('likes');
    Route::get('/blog/{blogUrl}', 'UserController@blog')->name('blog');
    Route::get('/blog/{blogUrl}/follow/', 'UserController@follow')->name('follow');
    Route::get('/blog/{blogUrl}/unfollow', 'UserController@unfollow')->name('unfollow');
    Route::post('/reblog', 'UserController@reblog')->name('reblog');
    Route::post('/post/like', 'UserController@like')->name('like');
    Route::post('/post/unlike', 'UserController@unlike')->name('unlike');

    Route::get('/following', 'UserController@getFollowedBlogs')->name('following');
});
