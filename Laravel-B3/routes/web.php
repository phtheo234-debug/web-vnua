<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Route trang chủ
Route::get('/', [PostController::class, 'index']);

// Nhóm các Route quản lý bài viết
Route::prefix('post')->name('post.')->group(function () {
    
    // 1. Danh sách bài viết & bộ lọc
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/user2', [PostController::class, 'user2'])->name('user2');

    // 2. Thêm bài viết mới
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/', [PostController::class, 'store'])->name('store');

    // 3. Quản lý Thùng rác (phải đặt trước route có tham số {id})
    Route::get('/trashed', [PostController::class, 'trashed'])->name('trashed');
    Route::patch('/{id}/restore', [PostController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [PostController::class, 'forceDelete'])->name('forceDelete');

    // 4. Chỉnh sửa & Xóa bài viết
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PostController::class, 'update'])->name('update');
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');

    // 5. Xem chi tiết bài viết (luôn đặt ở cuối cùng)
    Route::get('/{id}', [PostController::class, 'show'])->name('show');
});