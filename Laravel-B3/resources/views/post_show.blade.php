@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container py-4">
    <h2 class="mb-2">{{ $post->title }}</h2>
    <p class="text-muted mb-4">
        Danh mục: <strong>{{ $post->category }}</strong> | 
        Tác giả: {{ $post->author }} | 
        Ngày đăng: {{ $post->post_date }}
    </p>

    @if ($post->image)
        <div class="mb-4 text-center">
            <img src="{{ asset(str_starts_with($post->image, 'images/') ? $post->image : 'images/' . $post->image) }}" 
                 alt="{{ $post->title }}" 
                 class="img-fluid rounded shadow-sm">
        </div>
    @endif

    <div class="post-content my-4 fs-5">
        <p>{{ $post->excerpt }}</p>
    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('post.index') }}" class="btn btn-secondary">
            &larr; Quay lại danh sách
        </a>

        @auth
            @if($post->user_id === auth()->id())
                <div>
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-warning me-2">
                        Sửa bài viết
                    </a>

                    <form action="{{ route('post.destroy', $post->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa bài viết</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection