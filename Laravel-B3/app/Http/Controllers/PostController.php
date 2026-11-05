<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // Khai báo cố định 4 danh mục của đồ án
    public static $fixedCategories = [
        'Du lịch',
        'Phong cách sống',
        'Ẩm thực',
        'Cảm hứng'
    ];

    public function index(Request $request)
    {
        // Khởi tạo query từ Model Post
        $query = Post::query();

        // 1. Xử lý tìm kiếm theo từ khóa (tiêu đề hoặc excerpt)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // 2. Xử lý lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Sắp xếp mới nhất và phân trang (6 bài mỗi trang), giữ lại query string khi chuyển trang
        $posts = $query->orderBy('post_date', 'desc')->paginate(6)->withQueryString();

        // Sử dụng danh sách danh mục cố định thay vì truy vấn bảng categories
        $categories = self::$fixedCategories;

        return view('home', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('post_show', compact('post'));
    }

    public function create()
    {
        $categories = self::$fixedCategories;
        return view('post_create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu, ép buộc category phải nằm trong 4 danh mục cố định
        $request->validate([
            'category'  => ['required', 'string', 'in:' . implode(',', self::$fixedCategories)],
            'title'     => 'required|string|max:255',
            'excerpt'   => 'nullable|string',
            'author'    => 'required|string|max:100',
            'post_date' => 'required|date',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category',
            'title',
            'excerpt',
            'author',
            'post_date',
        ]);

        // Gán tự động ID của user đang đăng nhập
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        } else {
            $data['image'] = $request->input('image');
        }

        Post::create($data);

        return redirect()->route('post.index')->with('message', 'Thêm bài viết thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài viết này!');
        }

        $categories = self::$fixedCategories;

        return view('post_edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền cập nhật bài viết này!');
        }

        // Validate dữ liệu cập nhật, chặn các giá trị danh mục ngoài 4 danh mục chuẩn
        $request->validate([
            'category'  => ['required', 'string', 'in:' . implode(',', self::$fixedCategories)],
            'title'     => 'required|string|max:255',
            'excerpt'   => 'nullable|string',
            'author'    => 'required|string|max:100',
            'post_date' => 'required|date',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category',
            'title',
            'excerpt',
            'author',
            'post_date',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('images/' . $post->image))) {
                @unlink(public_path('images/' . $post->image));
            }

            $file = $request->file('image');
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        } elseif ($request->filled('image')) {
            $data['image'] = $request->input('image');
        } else {
            $data['image'] = $post->image;
        }

        $post->update($data);

        return redirect()->route('post.index')->with('message', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền xóa bài viết này!');
        }

        $post->delete();

        return redirect()->route('post.index')->with('message', 'Đã xóa mềm bài viết!');
    }

    public function trashed()
    {
        // Chỉ lấy các bài viết đã xóa mềm của chính user đang đăng nhập
        $posts = Post::onlyTrashed()->where('user_id', auth()->id())->get();

        return view('post_trashed', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền khôi phục bài viết này!');
        }

        $post->restore();

        return redirect()->route('post.trashed')->with('message', 'Khôi phục bài viết thành công!');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền xóa vĩnh viễn bài viết này!');
        }

        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            @unlink(public_path('images/' . $post->image));
        }

        $post->forceDelete();

        return redirect()->route('post.trashed')->with('message', 'Đã xóa vĩnh viễn bài viết!');
    }
}