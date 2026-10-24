<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::post('/', [ProductController::class, 'create'])->name('post.store');


// Route::get('/', function () {
//     return view('welcome');
// });
