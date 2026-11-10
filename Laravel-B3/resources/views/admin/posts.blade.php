@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Quản lý Tất cả Bài viết</h2>
            <p class="text-muted small mb-0">Kiểm duyệt và xử lý các bài viết vi phạm.</p>
        </div>
        <div>
            <a href="{{ route('admin.peculiar.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </div>

    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive mb-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase fs-7 text-secondary">
                    <tr>
                        <th class="py-3 ps-4">ID</th>
                        <th class="py-3">Ảnh</th>
                        <th class="py-3">Tiêu đề & Tác giả</th>
                        <th class="py-3">Danh mục</th>
                        <th class="py-3">Trạng thái</th>
                        <th class="py-3 text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="ps-4 fw-semibold text-muted">#{{ $post->id }}</td>
                            <td>
                                @if($post->image)
                                    <img src="{{ asset('images/' . $post->image) }}" width="70" height="50" class="rounded-3 shadow-sm object-fit-cover">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted small" style="width: 70px; height: 50px;">No img</div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate mb-1" style="max-width: 250px;">{{ $post->title }}</div>
                                <div class="text-muted small">Tác giả ID: {{ $post->user_id }} | Ngày: {{ date('d/m/Y H:i', strtotime($post->post_date)) }}</div>
                            </td>
                            <td><span class="badge bg-light text-primary border px-2 py-1 rounded-pill">{{ $post->category }}</span></td>
                            <td>
                                @if($post->trashed())
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1 rounded-pill small">Đã xóa mềm</span>
                                @elseif($post->status == 'published')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1 rounded-pill small">Đã đăng</span>
                                @elseif($post->status == 'draft')
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-2 py-1 rounded-pill small">Bản nháp</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-2 py-1 rounded-pill small">Hẹn giờ</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> Xem
                                    </a>
                                    <form action="{{ route('admin.peculiar.posts.delete', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Cảnh báo: Hành động này sẽ xóa vĩnh viễn bài viết vi phạm khỏi hệ thống!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fas fa-trash-alt me-1"></i> Xóa vi phạm
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Chưa có bài viết nào trên hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-4">{{ $posts->links() }}</div>
</div>
@endsection