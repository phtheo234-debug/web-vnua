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

    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Thay thế ô input danh mục thành thẻ select dropdown -->
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category" class="form-control" required>
                <option value="">-- Chọn danh mục --</option>
                <option value="Du lịch" {{ old('category') == 'Du lịch' ? 'selected' : '' }}>Du lịch</option>
                <option value="Phong cách sống" {{ old('category') == 'Phong cách sống' ? 'selected' : '' }}>Phong cách sống</option>
                <option value="Ẩm thực" {{ old('category') == 'Ẩm thực' ? 'selected' : '' }}>Ẩm thực</option>
                <option value="Cảm hứng" {{ old('category') == 'Cảm hứng' ? 'selected' : '' }}>Cảm hứng</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input name="title" class="form-control"
                   value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung tóm tắt</label>
            <textarea name="excerpt" class="form-control" rows="4">{{ old('excerpt') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input name="author" class="form-control"
                   value="{{ old('author', auth()->user()->name ?? 'Minh Anh') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày đăng</label>
            <input type="date" name="post_date" class="form-control"
                   value="{{ old('post_date', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh bài viết</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Chọn ảnh từ máy tính. Ảnh tải lên sẽ tự động lưu tên theo Datetime Seri.</small>
        </div>

        <button type="submit" class="btn btn-success">Lưu bài viết</button>
        <a href="{{ route('post.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection