<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông báo bình luận mới</title>
</head>
<body>
    <h2>Xin chào {{ $comment->post->user->name ?? 'Tác giả' }},</h2>
    <p>Bài viết <strong>{{ $comment->post->title }}</strong> của bạn vừa nhận được một bình luận mới từ thành viên <strong>{{ $comment->user->name ?? 'Ẩn danh' }}</strong>:</p>
    <blockquote>
        "{{ $comment->content }}"
    </blockquote>
    <p>Hãy truy cập website để xem và phản hồi bình luận nhé!</p>
</body>
</html>