<aside class="sidebar">

    <div class="sidebar-box about-box">
        <h4>It's me!</h4>

        <p>Xin chào! Dưới đây là những thứ có thể bạn sẽ cần về tôi!</p>
    </div>

    <div class="sidebar-box" id="danh-muc">
        <h4>Danh mục</h4>

        @if(count($categories) > 0)
            <ul class="category-list">
                @foreach($categories as $category)
                    <li>
                        <a href="#bai-viet">{{ $category }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Chưa có danh mục nào.</p>
        @endif
    </div>

    <div class="sidebar-box quote-box">
        <p>"Đi một ngày đàng, một sàng mệt mỏi...thế nào mà lại vui!"</p>
    </div>

</aside>