<?php

use App\Http\Controllers\Auth\TumblrLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('flush', function () {
    session()->flush();
    return redirect('/');
})->name('logout');

Route::group(['middleware' => 'has.token'], function () {
    Route::view('/', 'welcome')
        ->name('welcome');
});

Route::get('/auth/tumblr', [TumblrLoginController::class, 'auth'])
    ->name('tumblr.auth');

Route::get('/auth/tumblr/callback', [TumblrLoginController::class, 'callback']);

Route::group(['middleware' => 'tumblr'], function () {
    Route::get('/home/{type?}', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/post/{blog}/{id}/{slug?}', [HomeController::class, 'show'])
        ->name('post');

    Route::get('/create', [UserController::class, 'createPost'])
        ->name('create');

    Route::get('/likes', [UserController::class, 'likes'])
        ->name('likes');

    Route::get('/blog/{blogUrl}', [UserController::class, 'blog'])
        ->name('blog');

    Route::get('/blog/{blogUrl}/likes', [UserController::class, 'getBlogLikes'])
        ->name('getBlogLikes');

    Route::get('/blog/{blogUrl}/follow/', [UserController::class, 'follow'])
        ->name('follow');

    Route::get('/blog/{blogUrl}/unfollow', [UserController::class, 'unfollow'])
        ->name('unfollow');

    Route::get('/blog/{blogUrl}/tagged/{tag}', [UserController::class, 'tagged'])
        ->name('tagged');

    Route::post('/reblog', [UserController::class, 'reblog'])
        ->name('reblog');

    Route::post('/post/like', [UserController::class, 'like'])
        ->name('like');

    Route::post('/post/unlike', [UserController::class, 'unlike'])
        ->name('unlike');

    Route::get('/following', [UserController::class, 'getFollowedBlogs'])
        ->name('following');
});
