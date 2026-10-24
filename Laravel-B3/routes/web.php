<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = [
        [
            'category' => 'Du lịch',
            'title' => 'Một ngày bình yên ở Đà Lạt',
            'excerpt' => 'Đôi khi, điều chúng ta cần chỉ là một chuyến đi ngắn, một tách cà phê ấm và chút thời gian dành cho bản thân.',
            'author' => 'Thảo',
            'date' => '24/10/2026',
            'image' => 'images/a1.jpg'
        ],
        [
            'category' => 'Phong cách sống',
            'title' => 'Bắt đầu ngày mới với những thói quen nhỏ',
            'excerpt' => 'Một buổi sáng nhẹ nhàng có thể giúp bạn sắp xếp suy nghĩ và làm việc hiệu quả hơn.',
            'author' => 'Thảo và Trang',
            'date' => '22/10/2026',
            'image' => 'images/a2.jpg'
        ],
        [
            'category' => 'Ẩm thực',
            'title' => 'Góc cà phê nhỏ cho ngày cuối tuần',
            'excerpt' => 'Một góc thư giãn để đọc sách, nghe nhạc và tận hưởng ngày không vội vã.',
            'author' => 'Thảo',
            'date' => '20/10/2026',
            'image' => 'images/a3.jpg'
        ],
        [
            'category' => 'Cảm hứng',
            'title' => 'Học cách yêu những điều giản dị',
            'excerpt' => 'Niềm vui đôi khi đến từ những điều rất nhỏ mà ta thường vô tình bỏ qua.',
            'author' => 'Thảo và Tình',
            'date' => '18/10/2026',
            'image' => 'images/a4.jpg'
        ]
    ];

    $categories = [
        'Du lịch',
        'Phong cách sống',
        'Ẩm thực',
        'Cảm hứng'
    ];

    return view('home', compact('posts', 'categories'));
});