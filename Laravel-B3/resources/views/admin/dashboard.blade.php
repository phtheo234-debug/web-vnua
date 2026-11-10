@extends('layouts.app')

@section('title', 'Trang quản trị')

@section('content')
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Khu vực Quản trị viên</h2>
            <p class="text-muted small mb-0">Thống kê hệ thống và kiểm duyệt nội dung BLOG-WORLD.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.peculiar.posts') }}" class="btn btn-outline-primary rounded-pill px-3">Quản lý bài viết</a>
            <a href="{{ route('admin.peculiar.comments') }}" class="btn btn-outline-secondary rounded-pill px-3">Quản lý bình luận</a>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small opacity-75 mb-1">Tổng số thành viên</h6>
                        <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small opacity-75 mb-1">Bài viết đã đăng</h6>
                        <h3 class="fw-bold mb-0">{{ $totalPublishedPosts }}</h3>
                    </div>
                    <i class="fas fa-newspaper fa-2x opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small opacity-75 mb-1">Tổng số bình luận</h6>
                        <h3 class="fw-bold mb-0">{{ $totalComments }}</h3>
                    </div>
                    <i class="fas fa-comments fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 bài viết nhiều bình luận nhất -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h4 class="fw-bold text-dark mb-3"><i class="fas fa-fire text-danger me-2"></i> Top 5 bài viết nhiều bình luận nhất</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase fs-7 text-secondary">
                    <tr>
                        <th class="py-3">ID</th>
                        <th class="py-3">Tiêu đề bài viết</th>
                        <th class="py-3">Danh mục</th>
                        <th class="py-3 text-center">Số bình luận</th>
                        <th class="py-3 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPosts as $post)
                        <tr>
                            <td class="fw-semibold text-muted">#{{ $post->id }}</td>
                            <td class="fw-bold text-dark">{{ $post->title }}</td>
                            <td><span class="badge bg-light text-primary border px-2 py-1 rounded-pill">{{ $post->category }}</span></td>
                            <td class="text-center"><span class="badge bg-danger rounded-pill px-3">{{ $post->comments_count }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">Xem bài</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Chưa có bài viết nào có bình luận.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection