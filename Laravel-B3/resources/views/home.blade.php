@extends('layouts.app')

@section('title', 'Trang chủ | Thảo')

@section('content')

    <!-- Banner trang chủ -->
    <section class="hero-section">
        <div class="hero-overlay">
            <p class="eyebrow">BLOG CÁ NHÂN</p>
            <h1>Trạm dừng ngày nghỉ</h1>
            <p class="hero-text">Chậm lại để không bỏ lỡ điều gì</p>
            <a href="#bai-viet" class="btn btn-light hero-button">Khám phá bài viết</a>
        </div>
    </section>

    <!-- Nội dung chính -->
    <div class="row content-row" id="bai-viet">
        <section class="col-lg-8">
            <div class="section-heading d-flex justify-content-between align-items-center mb-3">
                <div>
                    <p class="eyebrow">GÓC CHIA SẺ</p>
                    <h2>Bài viết mới nhất</h2>
                </div>

                @auth
                    <div>
                        <a href="{{ route('post.create') }}" class="btn btn-sm btn-primary">+ Thêm bài mới</a>
                    </div>
                @endauth
            </div>

            @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(count($posts) > 0)
                @foreach($posts as $post)
                    <article class="post-card">
                        <a href="{{ route('post.show', $post->id) }}" class="post-image-link">
                            <img src="{{ asset(str_starts_with($post->image, 'images/') ? $post->image : 'images/' . ($post->image ?? 'default.jpg')) }}" 
                                 alt="{{ $post->title }}" 
                                 class="post-image">
                        </a>

                        <div class="post-info">
                            <span class="post-category">{{ $post->category }}</span>

                            <h3>
                                <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                            </h3>

                            <p class="post-excerpt">{{ $post->excerpt }}</p>

                            <div class="post-meta">
                                Bởi {{ $post->author }}
                                <br>{{ $post->post_date }}
                            </div>

                            @auth
                                @if($post->user_id === auth()->id())
                                    <div class="post-actions mt-3 pt-2 border-top">
                                        <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-outline-info">Xem</a>
                                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-warning">Sửa</a>
                                        
                                        <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                        </div>
                    </article>
                @endforeach
            @else
                <div class="alert alert-info">Hiện chưa có bài viết nào.</div>
            @endif
        </section>

        <div class="col-lg-4">
            @include('partials.sidebar')
        </div>
    </div>
@endsection