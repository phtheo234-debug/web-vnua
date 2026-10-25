<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // Danh sách bài viết
    public function index()
    {
        $posts = Post::orderBy('post_date', 'desc')->get();

        $categories = DB::table('categories')
            ->orderBy('name')
            ->pluck('name');

        return view('home', compact('posts', 'categories'));
    }

    // Xem chi tiết bài viết
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('post_show', compact('post'));
    }

    // Hiển thị form thêm
    public function create()
    {
        return view('post_create');
    }

    // Lưu bài viết mới
    // Hàm Thêm bài viết
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|integer',
            'category'  => 'required|string|max:100',
            'title'     => 'required|string|max:255',
            'excerpt'   => 'nullable|string',
            'author'    => 'required|string|max:100',
            'post_date' => 'required|date',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'user_id',
            'category',
            'title',
            'excerpt',
            'author',
            'post_date',
        ]);

        // 1. Nếu có file upload từ máy tính
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Luôn tạo tên Datetime Seri để lưu file mới, tuyệt đối không lo trùng file
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            
            $data['image'] = $filename;
        } 
        // 2. Nếu không upload file mà nhập/chọn chuỗi tên ảnh có sẵn
        else {
            $data['image'] = $request->input('image');
        }

        Post::create($data);

        return redirect()->route('post.index')->with('message', 'Thêm bài viết thành công!');
    }

    // Hàm Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'   => 'required|integer',
            'category'  => 'required|string|max:100',
            'title'     => 'required|string|max:255',
            'excerpt'   => 'nullable|string',
            'author'    => 'required|string|max:100',
            'post_date' => 'required|date',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $post = Post::findOrFail($id);
        $data = $request->only([
            'user_id',
            'category',
            'title',
            'excerpt',
            'author',
            'post_date',
        ]);

        // 1. Người dùng chọn/tải file mới từ máy tính
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Tạo tên Datetime Seri duy nhất và chuyển file vào public/images
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            $data['image'] = $filename;
        } 
        // 2. Người dùng nhập/chọn lại tên ảnh có sẵn (dạng string)
        elseif ($request->filled('image')) {
            $data['image'] = $request->input('image');
        } 
        // 3. Không chọn file mới cũng không nhập gì -> Giữ lại ảnh cũ
        else {
            $data['image'] = $post->image;
        }
        $post->update($data);

        return redirect()->route('post.index')->with('message', 'Cập nhật bài viết thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('post_edit', compact('post'));
    }

    // Xóa mềm bài viết
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('post.index')
            ->with('message', 'Đã xóa mềm bài viết!');
    }

    // Danh sách bài viết của user_id = 2 bằng Local Scope
    public function user2()
    {
        $posts = Post::cuaUser2()
            ->orderBy('post_date', 'desc')
            ->get();

        return view('home', [
            'posts' => $posts,
            'categories' => DB::table('categories')
                ->orderBy('name')
                ->pluck('name')
        ]);
    }

    // Hiển thị bài viết đã xóa mềm
    public function trashed()
    {
        $posts = Post::onlyTrashed()->get();

        return view('post_trashed', compact('posts'));
    }

    // Khôi phục bài viết đã xóa mềm
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->restore();

        return redirect()->route('post.trashed')
            ->with('message', 'Khôi phục bài viết thành công!');
    }

    // Xóa vĩnh viễn
    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        // Tùy chọn: Xóa ảnh thật trong thư mục public/images khi xóa vĩnh viễn
        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            @unlink(public_path('images/' . $post->image));
        }

        $post->forceDelete();

        return redirect()->route('post.trashed')
            ->with('message', 'Đã xóa vĩnh viễn bài viết!');
    }
}