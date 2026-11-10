<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // 1. Trang thống kê tổng quan
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPublishedPosts = Post::where('status', 'published')->count();
        $totalComments = Comment::count();

        // Top 5 bài viết nhiều bình luận nhất
        $topPosts = Post::withCount('comments')
                        ->orderBy('comments_count', 'desc')
                        ->take(5)
                        ->get();

        return view('admin.dashboard', compact('totalUsers', 'totalPublishedPosts', 'totalComments', 'topPosts'));
    }

    // 2. Quản lý tất cả bài viết (Xóa bài vi phạm)
    public function posts()
    {
        $posts = Post::withTrashed()->latest()->paginate(10);
        return view('admin.posts', compact('posts'));
    }

    public function deletePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        
        // Xóa ảnh vật lý nếu có
        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            @unlink(public_path('images/' . $post->image));
        }
        
        $postId = $post->id;
        $post->forceDelete();

        // Ghi Log cảnh báo khi Admin xóa vĩnh viễn bài viết vi phạm
        Log::alert('Quản trị viên đã xóa vĩnh viễn bài viết vi phạm', [
            'post_id' => $postId, 
            'admin_id' => auth()->id()
        ]);

        return back()->with('message', 'Đã xóa vĩnh viễn bài viết vi phạm!');
    }

    // 3. Quản lý bình luận
    public function comments()
    {
        $comments = Comment::with('post', 'user')->latest()->paginate(10);
        return view('admin.comments', compact('comments'));
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $commentId = $comment->id;
        $comment->delete();

        // Ghi Log khi Admin xóa bình luận vi phạm
        Log::warning('Quản trị viên đã xóa bình luận vi phạm', [
            'comment_id' => $commentId, 
            'admin_id' => auth()->id()
        ]);

        return back()->with('message', 'Đã xóa bình luận thành công!');
    }
}