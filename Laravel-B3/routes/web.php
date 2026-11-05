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
use App\Jobs\SendMailJob;
use App\Http\Controllers\CommentController;

Route::middleware('auth')->group(function () {
    // Gửi bình luận cho bài viết
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Xóa bình luận
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/mail', function(){
    SendMailJob::dispatchAfterResponse();
    return 'Email sent after 1 minute';
});

// Trang chủ trỏ về danh sách bài viết
Route::get('/', [PostController::class, 'index'])->name('home');

// Nhóm route dành cho khách (chưa đăng nhập)
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

    // Quên mật khẩu
    Route::get('/forgot-password', [UserController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [UserController::class, 'sendResetPassword'])->name('password.email');

    Route::get('/404', function (){
        abort(404);
    });
});

// Nhóm route yêu cầu đã đăng nhập (User / Member)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');
});

// Nhóm route quản lý Bài viết (Posts)
Route::prefix('post')->name('post.')->group(function () {
    
    // Xem danh sách bài viết (Công khai)
    Route::get('/', [PostController::class, 'index'])->name('index');
    
    // Đã xóa bỏ Route::get('/user2', ...) vì không còn dùng hàm user2()

    // Các tính năng yêu cầu đăng nhập
    Route::middleware('auth')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');

        // Thùng rác và khôi phục/xóa vĩnh viễn
        Route::get('/trashed', [PostController::class, 'trashed'])->name('trashed');
        Route::patch('/{id}/restore', [PostController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [PostController::class, 'forceDelete'])->name('forceDelete');

        // Chỉnh sửa, cập nhật và xóa mềm
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');
    });

    // Xem chi tiết bài viết (Đặt ở cuối để không xung đột với các route dạng /create, /trashed)
    Route::get('/{id}', [PostController::class, 'show'])->name('show');
});