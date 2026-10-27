<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::prefix('post')->name('post.')->group(function () {
    
    // Xem danh sách bài viết (Công khai)
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/user2', [PostController::class, 'user2'])->name('user2');

    //Đăng nhập
    Route::middleware('auth')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');

        Route::get('/trashed', [PostController::class, 'trashed'])->name('trashed');
        Route::patch('/{id}/restore', [PostController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [PostController::class, 'forceDelete'])->name('forceDelete');

        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');
    });

    // Xem chi tiết bài viết
    Route::get('/{id}', [PostController::class, 'show'])->name('show');
});