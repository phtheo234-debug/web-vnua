<aside class="sidebar p-4 bg-light rounded-4 shadow-sm border">

    <div class="sidebar-box about-box mb-4 text-center pb-3 border-bottom">
        <h4 class="text-primary fw-bold fs-5 mb-2">TẬN HƯỞNG</h4>
        <p class="text-muted small mb-0">Xin chào! Dưới đây là những thứ có thể bạn sẽ cần!</p>
    </div>

    <div class="sidebar-box mb-4" id="danh-muc">
        <h4 class="fw-bold fs-6 text-uppercase text-secondary mb-3 pb-2 border-bottom">
            <i class="fas fa-list-ul me-1"></i> Danh mục bài viết
        </h4>

        @if(isset($categories) && count($categories) > 0)
            <ul class="category-list list-unstyled ps-0 mb-0">
                @foreach($categories as $category)
                    <li class="mb-2">
                        <a href="{{ route('home', ['category' => $category]) }}#bai-viet" 
                           class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none text-dark bg-white border shadow-sm transition {{ request('category') == $category ? 'border-primary fw-bold text-primary' : '' }}">
                            <span><i class="fas fa-angle-right text-primary me-2"></i> {{ $category }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-warning small py-2 mb-0" role="alert">
                Chưa có danh mục nào.
            </div>
        @endif
    </div>

    <div class="sidebar-box quote-box p-3 bg-white rounded-3 border-start border-4 border-primary shadow-sm text-center">
        <p class="mb-0 fst-italic text-muted small">"Kết nối với thế giới thông qua <strong>BLOG-WORLD</strong>!"</p>
    </div>

</aside>