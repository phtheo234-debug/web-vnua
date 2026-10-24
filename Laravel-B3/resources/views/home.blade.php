@extends('layouts.app')

@section('title', 'Trang chủ | Thảo')

@section('content')

    <!-- Banner trang chu -->
    <section class="hero-section">
        <div class="hero-overlay">

            <p class="eyebrow">BLOG CÁ NHÂN</p>

            <h1>Trạm dừng ngày nghỉ</h1>

            <p class="hero-text">Chậm lại để không bỏ lỡ điều gì</p>

            <a href="#bai-viet" class="btn btn-light hero-button">Khám phá bài viết</a>
        </div>
    </section>

    <!-- Noi dung chinh -->
    <div class="row content-row" id="bai-viet">
        <section class="col-lg-8">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">GÓC CHIA SẺ</p>
                    <h2>Bài viết mới nhất</h2>
                </div>
            </div>

            @if(count($posts) > 0)
                @foreach($posts as $post)
                    <article class="post-card">
                        <a href="#bai-viet" class="post-image-link">
                            <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }}" class="post-image">
                        </a>

                        <div class="post-info">
                            <span class="post-category">{{ $post['category'] }}</span>

                            <h3>
                                <a href="#bai-viet">{{ $post['title'] }}</a>
                            </h3>

                            <p class="post-excerpt">{{ $post['excerpt'] }}</p>

                            <div class="post-meta">Bởi {{ $post['author'] }} <br> {{ $post['date'] }}</div>
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