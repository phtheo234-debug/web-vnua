@extends('layouts.app')

@section('title', 'Thùng rác bài viết')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Thùng rác bài viết</h2>
            <p class="text-muted small mb-0">Quản lý các bài viết đã xóa mềm. Bạn có thể khôi phục lại hoặc xóa vĩnh viễn.</p>
        </div>
        <a href="{{ route('post.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

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
                        <th class="py-3">Ngày xóa</th>
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

                            <td class="text-muted small">
                                {{ $post->deleted_at ? $post->deleted_at->format('d/m/Y H:i') : '' }}
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- Nút Khôi phục -->
                                    <form action="{{ route('post.restore', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                            <i class="fas fa-undo me-1"></i> Khôi phục
                                        </button>
                                    </form>

                                    <!-- Nút Xóa vĩnh viễn -->
                                    <form action="{{ route('post.forceDelete', $post->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn bài viết này? Hành động này không thể hoàn tác!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="fas fa-trash-alt me-1"></i> Xóa vĩnh viễn
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-trash fa-2x mb-2 d-block text-secondary opacity-50"></i>
                                Thùng rác trống. Không có bài viết nào bị xóa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection