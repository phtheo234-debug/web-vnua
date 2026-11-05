<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Mail\CommentNotificationMail;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    // Lưu bình luận mới
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($postId);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Gửi email thông báo qua Queue cho tác giả bài viết (nếu tác giả có email và khác người bình luận)
        if ($post->user && $post->user->email && $post->user->id !== auth()->id()) {
            Mail::to($post->user->email)->queue(new CommentNotificationMail($comment));
        }

        return back()->with('message', 'Thêm bình luận thành công!');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::with('post')->findOrFail($id);

        // Kiểm tra quyền xóa: chủ bình luận, tác giả bài viết, hoặc quản trị viên (admin)
        $isCommentOwner = $comment->user_id === auth()->id();
        $isPostOwner = $comment->post && $comment->post->user_id === auth()->id();
        $isAdmin = auth()->check() && (auth()->user()->role ?? '') === 'admin';

        if (!$isCommentOwner && !$isPostOwner && !$isAdmin) {
            abort(403, 'Bạn không có quyền xóa bình luận này!');
        }

        $comment->delete();

        return back()->with('message', 'Đã xóa bình luận thành công!');
    }
}