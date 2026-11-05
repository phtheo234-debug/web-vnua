@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="container py-5">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Quản lý bài viết</h2>
            <p class="text-muted small mb-0">Quản lý, chỉnh sửa và xuất bản các bài viết của bạn trên BLOG-WORLD.</p>
        </div>
        @auth
            <a href="{{ route('post.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-1"></i> Thêm bài viết mới
            </a>
        @endauth
    </div>

    <!-- Alert Message -->
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive mb-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase fs-7 text-secondary">
                    <tr>
                        <th class="py-3 ps-4">ID</th>
                        <th class="py-3">Ảnh</th>
                        <th class="py-3">Tiêu đề</th>
                        <th class="py-3">Danh mục</th>
                        <th class="py-3">Tác giả</th>
                        <th class="py-3">Ngày đăng</th>
                        <th class="py-3 text-end pe-4">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="ps-4 fw-semibold text-muted">#{{ $post->id }}</td>

                            <td>
                                @if($post->image)
                                    <img src="{{ asset('images/' . $post->image) }}"
                                         alt="{{ $post->title }}"
                                         width="70" height="50"
                                         class="rounded-3 shadow-sm object-fit-cover">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted small" style="width: 70px; height: 50px;">
                                        No img
                                    </div>
                                @endif
                            </td>

                            <td>
                                <span class="fw-bold text-dark text-truncate d-inline-block" style="max-width: 250px;">
                                    {{ $post->title }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-light text-primary border px-2 py-1 rounded-pill">
                                    {{ $post->category }}
                                </span>
                            </td>

                            <td class="text-muted">{{ $post->author }}</td>
                            <td class="text-muted small">{{ $post->post_date }}</td>

                            <td class="text-end pe-4">
                                @auth
                                    @if($post->user_id === auth()->id())
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('post.edit', $post->id) }}"
                                               class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                                <i class="fas fa-edit me-1"></i> Sửa
                                            </a>

                                            <form action="{{ route('post.destroy', $post->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill fw-light">Không có quyền</span>
                                    @endif
                                @else
                                    <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-light border rounded-pill px-3">Xem</a>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary opacity-50"></i>
                                Chưa có bài viết nào được tạo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection