<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() 
    {
        return view('product');
    }

    public function create(Request $request) 
    {
        // 1. Sử dụng Validate của Laravel (Tự động chuyển hướng back kèm lỗi nếu thiếu)
        $validated = $request->validate([
            'title'       => 'required',
            'slug'        => 'required',
            'description' => 'required', // Đã sửa chính tả: description
        ], [
            // Thông báo lỗi tiếng Việt tùy chỉnh (tùy chọn)
            'required' => 'Trường :attribute không được để trống.',
        ]);

        // 2. Trả về view kèm dữ liệu
        return view('product_view', [
            'title'       => $validated['title'],
            'slug'        => $validated['slug'],
            'description' => $validated['description'],
        ]);
    }
}