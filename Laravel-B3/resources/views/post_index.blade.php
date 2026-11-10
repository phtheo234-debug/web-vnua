@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Quản lý bài viết cá nhân</h2>
            <p class="text-muted small mb-0">Quản lý, chỉnh sửa, theo dõi trạng thái và xuất bản bài viết của bạn.</p>
        </div>
        @auth
            <div class="d-flex gap-2">
                <a href="{{ route('post.trashed') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-trash-alt me-1"></i> Thùng rác
                </a>
                <a href="{{ route('post.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus me-1"></i> Viết bài mới
                </a>
            </div>
        @endauth
    </div>

    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <ul class="nav nav-pills mb-4 gap-2">
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 {{ request('status') == '' ? 'active bg-primary text-white' : 'bg-light text-dark' }}" 
               href="{{ route('post.index') }}">
               Tất cả
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 {{ request('status') == 'published' ? 'active bg-success text-white' : 'bg-light text-dark' }}" 
               href="{{ route('post.index', ['status' => 'published']) }}">
               Đã đăng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 {{ request('status') == 'draft' ? 'active bg-secondary text-white' : 'bg-light text-dark' }}" 
               href="{{ route('post.index', ['status' => 'draft']) }}">
               Bản nháp
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4 {{ request('status') == 'scheduled' ? 'active bg-warning text-dark' : 'bg-light text-dark' }}" 
               href="{{ route('post.index', ['status' => 'scheduled']) }}">
               Hẹn giờ đăng
            </a>
        </li>
    </ul>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive mb-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase fs-7 text-secondary">
                    <tr>
                        <th class="py-3 ps-4">ID</th>
                        <th class="py-3">Ảnh</th>
                        <th class="py-3">Tiêu đề & Trạng thái</th>
                        <th class="py-3">Danh mục</th>
                        <th class="py-3">Ngày đăng / Hẹn giờ</th>
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
                                <div class="fw-bold text-dark text-truncate mb-1" style="max-width: 250px;">
                                    {{ $post->title }}
                                </div>
                                <!-- Hiển thị Badge trạng thái bài viết -->
                                <div>
                                    @if($post->status == 'published')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1 rounded-pill small">Đã đăng</span>
                                    @elseif($post->status == 'draft')
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-2 py-1 rounded-pill small">Bản nháp</span>
                                    @elseif($post->status == 'scheduled')
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-2 py-1 rounded-pill small">Hẹn giờ</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-primary border px-2 py-1 rounded-pill">
                                    {{ $post->category }}
                                </span>
                            </td>

                            <td class="text-muted small">
                                {{ date('d/m/Y H:i', strtotime($post->post_date)) }}
                            </td>

                            <td class="text-end pe-4">
                                @auth
                                    @if($post->user_id === auth()->id() || auth()->user()->role === 'admin')
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('post.edit', $post->id) }}"
                                               class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                                <i class="fas fa-edit me-1"></i> Sửa
                                            </a>

                                            <form action="{{ route('post.destroy', $post->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Bạn có chắc muốn đưa bài viết này vào thùng rác?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="{{ route('post.show', $post->slug) }}" class="btn btn-sm btn-light border rounded-pill px-3">Xem</a>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary opacity-50"></i>
                                Không tìm thấy bài viết nào trong mục này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>

</div>
@endsection