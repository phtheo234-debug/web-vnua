@extends('layouts.app')

@section('title', $post->title . ' | Blog Cộng Đồng')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Bài viết chi tiết -->
        <article class="card shadow-sm border-0 mb-4 p-4">
            <div class="mb-3">
                <span class="badge bg-primary">{{ $post->category }}</span>
                <span class="text-muted ms-2">Ngày đăng: {{ date('d/m/Y', strtotime($post->post_date)) }}</span>
                <span class="text-muted ms-2">Bởi: {{ $post->author }}</span>
            </div>

            <h1 class="fw-bold mb-4">{{ $post->title }}</h1>

            @if($post->image)
                <div class="mb-4 text-center">
                    <img src="{{ asset(str_starts_with($post->image, 'images/') ? $post->image : 'images/' . $post->image) }}" 
                         alt="{{ $post->title }}" 
                         class="img-fluid rounded shadow-sm w-100 object-fit-cover" style="max-height: 400px;">
                </div>
            @endif

            <div class="post-content fs-5 text-secondary">
                {!! nl2br(e($post->excerpt)) !!} 
            </div>
        </article>

        <section class="card shadow-sm border-0 p-4 mb-5">
            <h4 class="mb-4">Bình luận ({{ optional($post->comments)->count() ?? 0 }})</h4>

            <!-- Form gửi bình luận (Chỉ hiện khi đã đăng nhập) -->
            @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" rows="3" class="form-control" placeholder="Viết suy nghĩ của bạn về bài viết..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm px-4">Gửi bình luận</button>
                </form>
            @else
                <div class="alert alert-light border text-center py-3 mb-4">
                    Vui lòng <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Đăng nhập</a> để tham gia bình luận bài viết này.
                </div>
            @endauth

            <!-- Danh sách bình luận -->
            <div class="comments-list">
                @forelse($post->comments as $comment)
                    <div class="d-flex align-items-start border-bottom py-3">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold mb-0 text-dark">{{ $comment->user->name ?? 'Thành viên' }}</h6>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 text-secondary">{{ $comment->content }}</p>

                            <!-- Nút xóa bình luận (Chủ bình luận, tác giả bài viết, hoặc admin) -->
                            @auth
                                @if($comment->user_id === auth()->id() || $post->user_id === auth()->id() || (auth()->user()->role ?? '') === 'admin')
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger btn-sm p-0 text-decoration-none small" onclick="return confirm('Xóa bình luận này?')">Xóa</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3 mb-0">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                @endforelse
            </div>
        </section>

        <div class="mb-4">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Quay lại trang chủ</a>
        </div>
    </div>
</div>
@endsection