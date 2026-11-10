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
            <label class="form-label fw-bold">Danh mục</label>
            <select name="category" class="form-control" required>
                <option value="">-- Chọn danh mục --</option>
                <option value="Du lịch" {{ old('category', $post->category) == 'Du lịch' ? 'selected' : '' }}>Du lịch</option>
                <option value="Phong cách sống" {{ old('category', $post->category) == 'Phong cách sống' ? 'selected' : '' }}>Phong cách sống</option>
                <option value="Ẩm thực" {{ old('category', $post->category) == 'Ẩm thực' ? 'selected' : '' }}>Ẩm thực</option>
                <option value="Cảm hứng" {{ old('category', $post->category) == 'Cảm hứng' ? 'selected' : '' }}>Cảm hứng</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Tiêu đề</label>
            <input name="title" class="form-control"
                   value="{{ old('title', $post->title) }}" required>
        </div>

        <!-- Trạng thái bài viết (Nháp, Đã đăng, Hẹn giờ) -->
        <div class="mb-3">
            <label class="form-label fw-bold">Trạng thái bài viết</label>
            <select name="status" class="form-control" required>
                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Đã đăng (Công khai)</option>
                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Hẹn giờ đăng</option>
            </select>
            <small class="text-muted">Thay đổi trạng thái hiển thị của bài viết.</small>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Thẻ (Tags)</label>
            <input name="tags" class="form-control" placeholder="Ví dụ: laravel, php, hanoi" value="{{ old('tags', $post->tags) }}">
            <small class="text-muted">Các thẻ cách nhau bằng dấu phẩy.</small>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Nội dung tóm tắt</label>
            <textarea name="excerpt" class="form-control" rows="4">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Tác giả</label>
            <input name="author" class="form-control"
                   value="{{ old('author', $post->author) }}" required>
        </div>

        <!-- Ô chọn Ngày & Giờ -->
        <div class="mb-3" id="scheduledDateWrapper" style="display: none;">
            <label class="form-label fw-bold">Ngày & Giờ hẹn đăng</label>
            <input type="datetime-local" name="post_date" class="form-control" 
                value="{{ old('post_date', isset($post->post_date) ? date('Y-m-d\TH:i', strtotime($post->post_date)) : '') }}">
            <small class="text-muted">Chọn thời điểm trong tương lai để hệ thống tự động công khai bài viết.</small>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const statusSelect = document.getElementById('statusSelect');
                const dateWrapper = document.getElementById('scheduledDateWrapper');

                function toggleDateInput() {
                    if (statusSelect.value === 'scheduled') {
                        dateWrapper.style.display = 'block';
                    } else {
                        dateWrapper.style.display = 'none';
                    }
                }

                statusSelect.addEventListener('change', toggleDateInput);
                toggleDateInput();
            });
        </script>

        <div class="mb-3">
            <label class="form-label fw-bold">Ảnh bài viết</label>
            
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

        <button type="submit" class="btn btn-primary px-4">Cập nhật bài viết</button>
        <a href="{{ route('post.index') }}" class="btn btn-secondary px-4">Quay lại</a>
    </form>
</div>
@endsection