<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public static $fixedCategories = [
        'Du lịch',
        'Phong cách sống',
        'Ẩm thực',
        'Cảm hứng'
    ];

    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->routeIs('home')) {
            $now = Carbon::now();
            $query->where(function($q) use ($now) {
                $q->where('status', 'published')
                  ->orWhere(function($sub) use ($now) {
                      $sub->where('status', 'scheduled')
                          ->where('post_date', '<=', $now);
                  });
            });
        } else {
            // Luôn lọc theo user đang đăng nhập cho trang quản lý cá nhân (kể cả là admin)
            $query->where('user_id', auth()->id());

            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }
        }

        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Lọc theo tag
        if ($request->filled('tag')) {
            $query->where('tags', 'like', '%' . $request->input('tag') . '%');
        }

        $posts = $query->orderBy('post_date', 'desc')->paginate(6)->withQueryString();
        $categories = self::$fixedCategories;

        if ($request->routeIs('home')) {
            return view('home', compact('posts', 'categories'));
        } else {
            return view('post_index', compact('posts', 'categories'));
        }
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('post_show', compact('post'));
    }

    public function myPosts()
    {
        $posts = Post::where('user_id', auth()->id())->paginate(5);
        return view('post_index', compact('posts'));
    }

    public function create()
    {
        $categories = self::$fixedCategories;
        return view('post_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'  => ['required', 'string', 'in:' . implode(',', self::$fixedCategories)],
            'title'     => 'required|string|max:255',
            'tags'      => 'nullable', 
            'status'    => 'required|in:draft,published,scheduled',
            'excerpt'   => 'nullable|string',
            'author'    => 'required|string|max:100',
            'post_date' => 'nullable|date',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category',
            'title',
            'excerpt',
            'author',
            'status',
        ]);

        if ($request->status === 'scheduled' && $request->filled('post_date')) {
            $data['post_date'] = $request->post_date;
        } else {
            $data['post_date'] = Carbon::now();
        }

        if ($request->has('tags')) {
            $data['tags'] = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;
        } else {
            $data['tags'] = null;
        }

        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        $post = Post::create($data);

        Log::info('Bài viết mới đã được tạo', [
            'post_id' => $post->id, 
            'title' => $post->title, 
            'user_id' => auth()->id()
        ]);

        return redirect()->route('post.index')->with('message', 'Thêm bài viết thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Cho phép chỉnh sửa nếu là chủ bài viết HOẶC tài khoản là admin
        if ($post->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa bài viết này!');
        }

        $categories = self::$fixedCategories;
        return view('post_edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền cập nhật bài viết này!');
        }

        $request->validate([
            'category'  => ['required', 'string', 'in:' . implode(',', self::$fixedCategories)],
            'title'     => 'required|string|max:255',
            'tags'      => 'nullable',
            'status'    => 'required|in:draft,published,scheduled',
            'excerpt'   => 'nullable|string',
            'author'    => 'required|string|max:100',
            'post_date' => 'nullable|date',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category',
            'title',
            'excerpt',
            'author',
            'status',
        ]);

        if ($request->status === 'scheduled' && $request->filled('post_date')) {
            $data['post_date'] = $request->post_date;
        } else {
            $data['post_date'] = Carbon::now();
        }

        if ($request->has('tags')) {
            $data['tags'] = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;
        } else {
            $data['tags'] = null;
        }

        if ($request->title !== $post->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('images/' . $post->image))) {
                @unlink(public_path('images/' . $post->image));
            }

            $file = $request->file('image');
            $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        $post->update($data);

        Log::info('Bài viết đã được cập nhật', ['post_id' => $post->id, 'user_id' => auth()->id()]);

        return redirect()->route('post.index')->with('message', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa bài viết này!');
        }

        $post->delete();

        Log::warning('Bài viết đã bị đưa vào thùng rác', ['post_id' => $post->id, 'user_id' => auth()->id()]);

        return redirect()->route('post.index')->with('message', 'Đã đưa bài viết vào thùng rác!');
    }

    public function trashed()
    {
        $query = Post::onlyTrashed();
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }
        $posts = $query->get();
        return view('post_trashed', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền khôi phục bài viết này!');
        }

        $post->restore();

        Log::info('Bài viết đã được khôi phục từ thùng rác', ['post_id' => $post->id, 'user_id' => auth()->id()]);

        return redirect()->route('post.trashed')->with('message', 'Khôi phục bài viết thành công!');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa vĩnh viễn bài viết này!');
        }

        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            @unlink(public_path('images/' . $post->image));
        }

        $postId = $post->id;
        $post->forceDelete();

        Log::alert('Bài viết đã bị xóa vĩnh viễn', ['post_id' => $postId, 'user_id' => auth()->id()]);

        return redirect()->route('post.trashed')->with('message', 'Đã xóa vĩnh viễn bài viết!');
    }
}