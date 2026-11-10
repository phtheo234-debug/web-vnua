@extends('layouts.app')

@section('title', 'Trang chủ | BLOG-WORLD')

@section('content')

    <section class="hero-section rounded-4 p-5 mb-5 text-white bg-dark position-relative overflow-hidden shadow">
        <div class="hero-overlay position-relative z-1">
            <span class="badge bg-primary mb-2 px-3 py-2 text-uppercase">Cổng thông tin & Chia sẻ</span>
            <h1 class="display-5 fw-bold">BLOG-WORLD</h1>
            <p class="lead text-light">Nơi kết nối mọi khoảnh khắc từ các thành viên.</p>
            @guest
                <div class="mt-4">
                    <a href="{{ route('register') }}" class="btn btn-primary me-2 px-4 rounded-pill">Tham gia ngay!</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light px-4 rounded-pill">Đăng nhập</a>
                </div>
            @else
                <div class="mt-4">
                    <a href="{{ route('post.create') }}" class="btn btn-primary px-4 rounded-pill shadow-sm">
                        <i class="fas fa-plus me-1"></i> Viết bài chia sẻ mới
                    </a>
                </div>
            @endguest
        </div>
    </section>

    <div class="row content-row" id="bai-viet">
        
        <section class="col-lg-8">
            
            <div class="section-heading d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <div>
                    <h2 class="h4 fw-bold mb-0 text-dark">
                        @if(request('category'))
                            Danh mục: <span class="text-primary">{{ request('category') }}</span>
                        @elseif(request('tag'))
                            Tag: <span class="text-primary">#{{ request('tag') }}</span>
                        @else
                            Bài viết mới nhất
                        @endif
                    </h2>
                </div>
                @if(request('category') || request('tag') || request('search'))
                    <a href="{{ route('home') }}#bai-viet" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Tất cả bài viết
                    </a>
                @endif
            </div>

            <!-- Form Tìm kiếm, Lọc danh mục & Lọc theo Tag -->
            <form action="{{ route('home') }}" method="GET" class="mb-4 row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Tìm kiếm từ khóa..." value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Tất cả danh mục</option>
                        @if(isset($categories))
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" name="tag" class="form-control" placeholder="Lọc theo tag (VD: php)..." value="{{ request('tag') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">Lọc</button>
                </div>
            </form>

            @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Danh sách bài viết -->
            @if(isset($posts) && count($posts) > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0 post-card rounded-4 overflow-hidden hover-shadow transition">
                                <a href="{{ route('post.show', $post->slug ?? $post->id) }}" class="post-image-link overflow-hidden">
                                    <img src="{{ $post->image ? asset(str_starts_with($post->image, 'images/') ? $post->image : 'images/' . $post->image) : asset('images/default.jpg') }}" 
                                         alt="{{ $post->title }}" 
                                         class="card-img-top object-fit-cover" style="height: 200px;">
                                </a>

                                <div class="card-body d-flex flex-column p-4">
                                    <!-- Danh mục -->
                                    <div class="mb-2">
                                        <span class="badge bg-light text-primary border px-2 py-1 rounded-pill">{{ $post->category }}</span>
                                    </div>

                                    <h5 class="card-title">
                                        <a href="{{ route('post.show', $post->slug ?? $post->id) }}" class="text-decoration-none text-dark fw-bold">
                                            {{ $post->title }}
                                        </a>
                                    </h5>

                                    <p class="card-text text-muted small mb-2">
                                        {{ Str::limit($post->excerpt, 90) }}
                                    </p>

                                    <!-- Thẻ Tag -->
                                    @if($post->tags)
                                        <div class="mb-3 d-flex flex-wrap gap-1">
                                            @foreach(explode(',', $post->tags) as $t)
                                                <a href="{{ route('home', ['tag' => trim($t)]) }}#bai-viet" class="badge bg-light text-secondary border text-decoration-none px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                                    #{{ trim($t) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top small text-muted">
                                        <span><i class="fas fa-user-circle me-1"></i>Tác giả: {{ $post->author }}</span>
                                        <span><i class="far fa-calendar-alt me-1"></i>Ngày đăng: {{ date('d/m/Y', strtotime($post->post_date)) }}</span>
                                    </div>

                                    <!-- Nút quản lý cho chủ nhân bài viết -->
                                    @auth
                                        @if($post->user_id === auth()->id())
                                            <div class="post-actions mt-3 pt-2 border-top d-flex gap-2 position-relative z-2">
                                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-warning w-50 rounded-pill">
                                                    <i class="fas fa-edit me-1"></i> Sửa
                                                </a>
                                                
                                                <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="w-50 m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                        <i class="fas fa-trash-alt me-1"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>

            @else
                <div class="alert alert-light border text-center py-5 rounded-4 shadow-sm">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-50"></i>
                    <p class="text-muted mb-0">Không tìm thấy bài viết phù hợp với yêu cầu của bạn.</p>
                </div>
            @endif
        </section>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 80px;">
                @include('partials.sidebar')
            </div>
        </div>

    </div>
@endsection