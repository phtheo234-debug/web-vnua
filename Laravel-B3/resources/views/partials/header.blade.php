<header class="site-header sticky-top bg-white shadow-sm border-bottom">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light px-0 py-3">

            <!-- Brand Logo -->
            <a class="navbar-brand brand fw-bold text-primary fs-4 tracking-wide" href="{{ url('/') }}">
                <i class="fas fa-globe-americas me-1"></i> BLOG-WORLD
            </a>

            <!-- Toggler Mobile -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav mx-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link px-3 fw-medium text-dark hover-primary active" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 fw-medium text-dark hover-primary" href="{{ url('/') }}#bai-viet">Bài viết</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 fw-medium text-dark hover-primary" href="#danh-muc">Danh mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 fw-medium text-dark hover-primary" href="#lien-he">Liên hệ</a>
                    </li>
                </ul>

                <!-- Auth Section -->
                <ul class="navbar-nav ml-auto align-items-lg-center gap-2 mt-3 mt-lg-0">
                    @auth
                        <!-- Hiển thị tên người dùng -->
                        <li class="nav-item d-flex align-items-center me-2 text-muted small d-none d-lg-block">
                            <span>👋 Chào, <strong>{{ auth()->user()->name }}</strong></span>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('password.change') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">
                                <i class="fas fa-key me-1"></i> Đổi mật khẩu
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger px-3 rounded-pill" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                            </a>
                        </li>
                    @else
                        <li class="nav-item me-lg-2">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill w-100 mb-2 mb-lg-0">
                                Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm w-100">
                                Đăng ký ngay
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</header>