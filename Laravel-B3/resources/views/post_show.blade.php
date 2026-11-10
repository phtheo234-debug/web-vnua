@extends('layouts.app')

@section('title', $post->title . ' | Blog Cộng Đồng')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <article class="card shadow-sm border-0 mb-4 p-4 rounded-4">
            <div class="mb-4 d-flex flex-wrap align-items-center">
                <span class="badge badge-primary px-3 py-2 rounded-pill mr-3 mb-2">{{ $post->category }}</span>
                <span class="text-muted mr-3 mb-2"><i class="far fa-calendar-alt mr-2"></i>Ngày đăng: {{ date('d/m/Y', strtotime($post->post_date)) }}</span>
                <span class="text-muted mb-2"><i class="fas fa-user-circle mr-2"></i>Bởi: {{ $post->author }}</span>
            </div>

            @if($post->tags)
                <div class="mb-3">
                    <span class="fw-bold text-secondary small me-2"><i class="fas fa-tags me-1"></i>Thẻ:</span>
                    @foreach(explode(',', $post->tags) as $tag)
                        <a href="{{ route('home', ['tag' => trim($tag)]) }}#bai-viet" class="badge bg-light text-primary border text-decoration-none me-1 px-2 py-1 rounded-pill small">
                            #{{ trim($tag) }}
                        </a>
                    @endforeach
                </div>
            @endif

            <h1 class="fw-bold mb-4 text-dark">{{ $post->title }}</h1>

            @if($post->image)
                <div class="mb-4 text-center">
                    <img src="{{ asset(str_starts_with($post->image, 'images/') ? $post->image : 'images/' . $post->image) }}" 
                         alt="{{ $post->title }}" 
                         class="img-fluid rounded-4 shadow-sm w-100 object-fit-cover" style="max-height: 400px;">
                </div>
            @endif

            <div class="post-content fs-5 text-secondary">
                {!! nl2br(e($post->excerpt)) !!} 
            </div>
        </article>

        <section class="card shadow-sm border-0 p-4 mb-5 rounded-4">
            <h4 class="mb-4">Bình luận ({{ optional($post->comments)->count() ?? 0 }})</h4>

            @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" rows="3" class="form-control rounded-3" placeholder="Viết suy nghĩ của bạn về bài viết..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">Gửi bình luận</button>
                </form>
            @else
                <div class="alert alert-light border text-center py-3 mb-4 rounded-3">
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

                            <!-- Nút xóa bình luận (Chủ bình luận, tác giả bài viết, admin) -->
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
            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4">← Quay lại trang chủ</a>
        </div>
    </div>
</div>
@endsection