<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::group(['prefix' => 'dashboard', 'middleware' => ['role:admin']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => '/users'], function () {
            Route::get('/', [DashboardController::class, 'users'])->name('dashboard.users');
            Route::delete('/{id}', [DashboardController::class, 'deleteUser'])->name('dashboard.users.destroy');
            Route::post('/{id}/toggle-admin', [DashboardController::class, 'toggleAdmin'])->name('dashboard.users.toggle-admin');
        });
        Route::get('/posts', [DashboardController::class, 'posts'])->name('dashboard.posts');
        Route::get('/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
        Route::get('/likes', [DashboardController::class, 'likes'])->name('dashboard.likes');
        Route::delete('/likes', [DashboardController::class, 'deleteLike'])->name('dashboard.likes.destroy');
        Route::resource('/categories', CategoryController::class);
    });

    Route::resource('posts', PostController::class)->except(['show', 'index']);
    Route::get('posts/saved', [PostController::class, 'saved'])->name('posts.saved');
    Route::get('posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
    Route::get('posts/{id}/save', [PostController::class, 'save'])->name('posts.save');
    Route::delete('post/{post_id}/image/{id}', [PostController::class, 'deleteImage'])->name('posts.image.destroy');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/follow/{id}', [UserController::class, 'toggleFollow'])->name('users.follow');
    Route::get('/user/{id}/followers', [UserController::class, 'followers'])->name('users.followers');
    Route::get('/user/{id}/following', [UserController::class, 'following'])->name('users.following');
    Route::get('/user/{id}/remove-following', [UserController::class, 'removeFollowing'])->name('users.remove-following');
    Route::get('/search/users/', [UserController::class, 'search'])->name('search.users');
    Route::post('/posts/{id}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::get('/comment/{id}/edit', [PostController::class, 'editComment'])->name('posts.comment.edit');
    Route::put('/comment/{id}', [PostController::class, 'updateComment'])->name('posts.comment.update');
    Route::delete('/comment/{id}', [PostController::class, 'deleteComment'])->name('posts.comment.destroy');
    Route::get('/search/posts/', [PostController::class, 'search'])->name('search.posts');
});

Route::redirect('/', '/posts')->name('home');
Route::resource('posts', PostController::class)->only(['show', 'index']);
Route::get('/posts/category/{category}', [PostController::class, 'category'])->name('posts.category');
