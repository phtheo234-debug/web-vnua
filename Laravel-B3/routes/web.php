<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;

Route::get('/mail', function(){
    Mail::to('thao@example.com')->send(new VerifyEmail('Tạ Phương Thảo'));
    return 'Email sent';
});

Route::get('/notify', function(){
    Notification::route('mail', 'thao@example.com')->notify(new VerifyEmailNotification('Tạ Phương Thảo'));
    return 'Notification sent';
});

Route::get('/', [PostController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

    // === BỔ SUNG CÁC ROUTE QUÊN MẬT KHẨU TẠI ĐÂY ===
    Route::get('/forgot-password', [UserController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [UserController::class, 'sendResetPassword'])->name('password.email');

    Route::get('/404', function (){
        abort(404);
    } );
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');
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