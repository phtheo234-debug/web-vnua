@extends('layouts.app')

@section('title', 'Thêm bài viết')

@section('content')
<div class="container py-4">
    <h2>Thêm bài viết</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Bổ sung enctype="multipart/form-data" để upload file -->
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="user_id" value="1">

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <input name="category" class="form-control"
                   value="{{ old('category') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input name="title" class="form-control"
                   value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung tóm tắt</label>
            <textarea name="excerpt" class="form-control">{{ old('excerpt') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input name="author" class="form-control"
                   value="{{ old('author', 'Minh Anh') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày đăng</label>
            <input type="date" name="post_date" class="form-control"
                   value="{{ old('post_date', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
        <label class="form-label">Ảnh bài viết</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Chọn ảnh từ máy tính. Nếu là ảnh mới sẽ tự động lưu tên theo Datetime Seri, nếu ảnh đã có sẵn trong hệ thống sẽ tự động nhận diện.</small>
        </div>

        <button class="btn btn-success">Lưu bài viết</button>
        <a href="{{ route('post.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection