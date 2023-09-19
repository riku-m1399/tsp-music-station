<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CategoryController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'],function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    // Post
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/show/{id}', [PostController::class, 'show'])->name('post.show');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/post/update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/destroy/{id}', [PostController::class, 'destroy'])->name('post.destroy');

    // Profile
    Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/followers/{id}', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/following/{id}', [ProfileController::class, 'following'])->name('profile.following');

    // Comment
    Route::post('/comment/store/{post_id}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/destroy/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Like
    Route::post('/like/store/{id}', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/destroy/{id}', [LikeController::class, 'destroy'])->name('like.destroy');

    // Follow
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    // Category
    Route::get('/category/show/{id}', [CategoryController::class, 'show'])->name('category.show');
});


// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
