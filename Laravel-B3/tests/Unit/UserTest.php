<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /** Test 1 (Thành công): Kiểm tra hàm isAdmin trả về true nếu user là admin */
    public function test_user_is_admin_successfully()
    {
        $user = new User(['role' => 'admin']);
        $this->assertTrue($user->isAdmin());
    }

    /** Test 2 (Thất bại/Trường hợp ngược lại): Kiểm tra hàm isAdmin trả về false nếu user là member */
    public function test_user_is_not_admin_for_member()
    {
        $user = new User(['role' => 'member']);
        $this->assertFalse($user->isAdmin());
    }
}