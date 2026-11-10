<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;

// 1. Trang chủ trỏ về danh sách bài viết
Route::get('/', [PostController::class, 'index'])->name('home');

// 2. Nhóm route dành cho khách (chưa đăng nhập)
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

// 3. Nhóm route yêu cầu đã đăng nhập
Route::middleware(['auth'])->group(function () {
    // Đăng xuất
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Quản lý hồ sơ cá nhân & Đổi mật khẩu
    Route::get('/profile/edit', [UserController::class, 'showChangePassword'])->name('password.change');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('password.update');

    // Gửi & Xóa bình luận
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// 4. Khu vực dành riêng cho Quản trị viên (Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.peculiar.')->group(function () {
    // Thống kê tổng quan
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Quản lý bài viết vi phạm
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
    Route::delete('/posts/{id}', [AdminController::class, 'deletePost'])->name('posts.delete');

    // Quản lý bình luận vi phạm
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
    Route::delete('/comments/{id}', [AdminController::class, 'deleteComment'])->name('comments.delete');
});

// 5. Nhóm route quản lý Bài viết (Posts) của người dùng
Route::prefix('post')->name('post.')->group(function () {
    
    // Các tính năng quản lý bài viết bắt buộc phải ĐĂNG NHẬP
    Route::middleware('auth')->group(function () {
        // Trang quản lý bài viết CÁ NHÂN (Truy cập vào /post)
        Route::get('/', [PostController::class, 'index'])->name('index');

        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');

        // Thùng rác và khôi phục / xóa vĩnh viễn
        Route::get('/trashed', [PostController::class, 'trashed'])->name('trashed');
        Route::patch('/{id}/restore', [PostController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [PostController::class, 'forceDelete'])->name('forceDelete');

        // Chỉnh sửa, cập nhật và xóa bài viết
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');
    });

    // Xem chi tiết bài viết công khai (đặt ở dưới cùng để tránh xung đột với các route trên)
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
});