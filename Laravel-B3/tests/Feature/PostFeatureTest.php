<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostFeatureTest extends TestCase
{
    use RefreshDatabase; // Tự động tạo và dọn sạch bảng trong mỗi lần test

    /** 1. Test Đăng nhập thành công */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::create([
            'name' => 'Thảo',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/post');
    }

    /** 2. Test Đăng nhập thất bại (sai mật khẩu) */
    public function test_user_cannot_login_with_incorrect_password()
    {
        User::create([
            'name' => 'Thảo',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    /** 3. Test Tạo bài viết thành công khi đã đăng nhập */
    public function test_authenticated_user_can_create_a_post()
    {
        $user = User::create([
            'name' => 'Thảo',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $response = $this->actingAs($user)->post('/post', [
            'category' => 'Du lịch',
            'title' => 'Bài viết kiểm thử tự động',
            'excerpt' => 'Nội dung tóm tắt kiểm thử',
            'author' => $user->name,
            'post_date' => '2026-10-30',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('posts', ['title' => 'Bài viết kiểm thử tự động']);
        $response->assertRedirect(route('post.index'));
    }

    /** 4. Test Tạo bài viết thất bại do thiếu tiêu đề */
    public function test_create_post_validation_fails_if_title_is_missing()
    {
        $user = User::create([
            'name' => 'Thảo',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $response = $this->actingAs($user)->post('/post', [
            'category' => 'Du lịch',
            'title' => '', // Thiếu tiêu đề
            'excerpt' => 'Nội dung tóm tắt',
            'author' => $user->name,
            'post_date' => '2026-10-30',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /** 5. Test Chủ sở hữu được phép truy cập trang chỉnh sửa bài viết */
    public function test_author_can_access_edit_post_page()
    {
        $user = User::create([
            'name' => 'Thảo',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $post = Post::create([
            'category' => 'Du lịch',
            'title' => 'Bài viết của tôi',
            'excerpt' => 'Mô tả',
            'author' => $user->name,
            'post_date' => '2026-10-30',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get("/post/{$post->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('post_edit');
    }

    /** 6. Test Chặn người dùng khác chỉnh sửa bài viết (Lỗi 403) */
    public function test_other_user_cannot_edit_someone_elses_post()
    {
        $owner = User::create([
            'name' => 'Chủ bài viết',
            'email' => 'owner@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $otherUser = User::create([
            'name' => 'Người khác',
            'email' => 'other@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $post = Post::create([
            'category' => 'Du lịch',
            'title' => 'Bài viết của chủ nhà',
            'excerpt' => 'Mô tả',
            'author' => $owner->name,
            'post_date' => '2026-10-30',
            'user_id' => $owner->id
        ]);

        $response = $this->actingAs($otherUser)->get("/post/{$post->id}/edit");

        $response->assertStatus(403);
    }

    /** 7. Test Thành viên đã đăng nhập có thể gửi bình luận */
    public function test_authenticated_user_can_add_comment_to_post()
    {
        $user = User::create([
            'name' => 'Thảo',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $post = Post::create([
            'category' => 'Du lịch',
            'title' => 'Bài viết mẫu',
            'excerpt' => 'Mô tả',
            'author' => $user->name,
            'post_date' => '2026-10-30',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->post("/posts/{$post->id}/comments", [
            'content' => 'Bình luận kiểm thử!',
        ]);

        $this->assertDatabaseHas('comments', ['content' => 'Bình luận kiểm thử!']);
        $response->assertRedirect(); // Thay assertBack() bằng assertRedirect()
    }

    /** 8. Test Khách vãng lai không thể bình luận */
    public function test_guest_cannot_add_comment_and_is_redirected()
    {
        $user = User::create([
            'name' => 'Thảo',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $post = Post::create([
            'category' => 'Du lịch',
            'title' => 'Bài viết mẫu',
            'excerpt' => 'Mô tả',
            'author' => $user->name,
            'post_date' => '2026-10-30',
            'user_id' => $user->id
        ]);

        $response = $this->post("/posts/{$post->id}/comments", [
            'content' => 'Bình luận của khách',
        ]);

        $response->assertRedirect('/login');
    }
}