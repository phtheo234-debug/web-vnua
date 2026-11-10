<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\PostController;

class PostUnitTest extends TestCase
{
    /** 1. Unit Test Thành công: Kiểm tra danh mục cố định có đúng 4 danh mục của đồ án không */
    public function test_fixed_categories_has_exact_four_items()
    {
        $categories = PostController::$fixedCategories;
        
        $this->assertCount(4, $categories);
        $this->assertContains('Du lịch', $categories);
        $this->assertContains('Ẩm thực', $categories);
    }

    /** 2. Unit Test Thất bại: Kiểm tra danh mục cố định không được chứa danh mục ngoài luồng */
    public function test_fixed_categories_does_not_contain_invalid_item()
    {
        $categories = PostController::$fixedCategories;
        
        $this->assertNotContains('Công nghệ thông tin', $categories);
        $this->assertNotContains('Thể thao', $categories);
    }
}