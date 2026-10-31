<header class="site-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light px-0">

            <a class="navbar-brand brand" href="{{ url('/') }}">Thảo</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#bai-viet">Bài viết</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#danh-muc">Danh mục</a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="#lien-he">Liên hệ</a>
                    </li>

                    @auth
                        <li class="nav-item mr-2">
                            <a href="{{ route('password.change') }}" class="btn btn-sm btn-outline-secondary">
                                Đổi mật khẩu
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>
                        </li>
                    @else
                        <li class="nav-item mr-2">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-sm btn-primary">
                                Đăng ký
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</header>