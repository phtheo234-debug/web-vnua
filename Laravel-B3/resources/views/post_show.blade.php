@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container py-4">
    <h2>{{ $post->title }}</h2>
    <p class="text-muted">Tiêu đề: <strong>{{ $post->category }}</strong> | Tác giả: {{ $post->author }} | Ngày đăng: {{ $post->post_date }}</p>

    <!-- Hiển thị ảnh bài viết -->
    @if ($post->image)
        <div class="mb-3">
            <img src="{{ asset(str_starts_with($post->image, 'images/') ? $post->image : 'images/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded" style="max-height: 400px;">
        </div>
    @endif

    <div class="post-content my-4">
        <p>{{ $post->excerpt }}</p>
    </div>

    <a href="{{ route('post.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
</div>
@endsection