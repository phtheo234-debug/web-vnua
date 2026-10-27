@extends('layouts.app')

@section('title', 'Sửa bài viết')

@section('content')
<div class="container py-4">
    <h2>Sửa bài viết</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <input name="category" class="form-control"
                   value="{{ old('category', $post->category) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input name="title" class="form-control"
                   value="{{ old('title', $post->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung tóm tắt</label>
            <textarea name="excerpt" class="form-control" rows="4">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input name="author" class="form-control"
                   value="{{ old('author', $post->author) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày đăng</label>
            <input type="date" name="post_date" class="form-control"
                   value="{{ old('post_date', $post->post_date) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh bài viết</label>
            
            @if($post->image)
                <div class="mb-2">
                    <span class="d-block text-muted mb-1">Ảnh hiện tại:</span>
                    <img src="{{ asset('images/' . $post->image) }}" 
                         alt="{{ $post->title }}" 
                         style="max-height: 150px; object-fit: cover;" 
                         class="img-thumbnail">
                </div>
            @endif

            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Bỏ trống nếu muốn giữ lại ảnh cũ. Nếu chọn ảnh mới, hệ thống sẽ tự động lưu tên theo Datetime Seri.</small>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
        <a href="{{ route('post.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection