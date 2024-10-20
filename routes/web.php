<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;

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

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/', [PostController::class, 'index'])->name('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/follows', [FollowController::class, 'index'])->name('follow.index');
});

Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');
Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('user.follow');
Route::delete('/users/{user}/unfollow', [FollowController::class, 'destroy'])->name('user.unfollow');
Route::get('/users/{user}/followers-followings', [UserController::class, 'followersFollowings'])->name('user.followers_followings');

Route::get('/chats', [ChatController::class, 'chatList'])->name('chats.list');
Route::get('/chat/{user}', [ChatController::class, 'openChat'])->name('chat.open');
Route::post('/chat', [ChatController::class, 'sendMessage'])->name('chat.send');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::post('/like', [LikeController::class, 'store'])->name('like.store');

require __DIR__.'/auth.php';