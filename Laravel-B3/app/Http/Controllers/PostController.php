<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết
        $posts = Post::orderBy('post_date', 'desc')->get();

        // Lấy danh sách danh mục
        $categories = DB::table('categories')
            ->orderBy('name')
            ->pluck('name');

        // Truyền dữ liệu sang giao diện
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
        return view('post_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'  => 'required|string|max:100',
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

        return view('post_edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền cập nhật bài viết này!');
        }

        $request->validate([
            'category'  => 'required|string|max:100',
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

    public function trashed()
    {
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