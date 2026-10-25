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

        <input type="hidden" name="user_id" value="{{ $post->user_id }}">

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
            <textarea name="excerpt" class="form-control">{{ old('excerpt', $post->excerpt) }}</textarea>
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

        <!-- Xem trước ảnh hiện tại -->
        <div class="mb-3">
        <label class="form-label">Ảnh bài viết</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Chọn ảnh từ máy tính. Nếu là ảnh mới sẽ tự động lưu tên theo Datetime Seri, nếu ảnh đã có sẵn trong hệ thống sẽ tự động nhận diện.</small>
        </div>

        <button class="btn btn-primary">Cập nhật bài viết</button>
        <a href="{{ route('post.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection