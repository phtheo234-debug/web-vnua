@extends('layouts.app')

@section('title', 'Quản lý bình luận')

@section('content')
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Quản lý Bình luận</h2>
            <p class="text-muted small mb-0">Kiểm duyệt và xóa các bình luận vi phạm.</p>
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
                        <th class="py-3">Người bình luận</th>
                        <th class="py-3">Nội dung</th>
                        <th class="py-3">Bài viết thuộc về</th>
                        <th class="py-3 text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td class="ps-4 fw-semibold text-muted">#{{ $comment->id }}</td>
                            <td class="fw-bold text-dark">{{ $comment->user->name ?? 'Ẩn danh' }}</td>
                            <td>{{ $comment->content }}</td>
                            <td><span class="text-primary">{{ $comment->post->title ?? 'Bài viết đã xóa' }}</span></td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.peculiar.comments.delete', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Chưa có bình luận nào trên hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-4">{{ $comments->links() }}</div>
</div>
@endsection