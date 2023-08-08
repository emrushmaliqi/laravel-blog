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
    Route::redirect('/', '/posts')->name('home');

    Route::group(['prefix' => 'dashboard', 'middleware' => ['role:admin']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => '/users'], function () {
            Route::get('/', [DashboardController::class, 'users'])->name('dashboard.users');
            Route::delete('/{id}', [DashboardController::class, 'deleteUser'])->name('dashboard.users.destroy');
        });
        Route::get('/posts', [DashboardController::class, 'posts'])->name('dashboard.posts');
        Route::get('/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
        Route::resource('/categories', CategoryController::class);
    });

    Route::get('/posts/category/{category}', [PostController::class, 'category'])->name('posts.category');
    Route::resource('posts', PostController::class);
    Route::get('/user/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/follow/{id}', [UserController::class, 'toggleFollow'])->name('users.follow');
    Route::get('/user/{id}/followers', [UserController::class, 'followers'])->name('users.followers');
    Route::get('/user/{id}/following', [UserController::class, 'following'])->name('users.following');
    Route::get('/user/{id}/remove-following', [UserController::class, 'removeFollowing'])->name('users.remove-following');
    Route::get('/search/posts/', [PostController::class, 'search'])->name('search.posts');
    Route::post('/posts/{id}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::delete('/posts/{post_id}/comment/{id}', [PostController::class, 'deleteComment'])->name('posts.comment.destroy');
    Route::get('/search/users/', [UserController::class, 'search'])->name('search.users');
});
