<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Tự động chuyển trạng thái các bài viết hẹn giờ đã đến hạn sang đã đăng';

    public function handle()
    {
        // Giả sử bạn có cột status và published_at trong bảng posts
        // Nếu dùng logic post_date hoặc cột status, bạn tinh chỉnh tại đây:
        $count = Post::where('status', 'scheduled')
            ->where('published_at', '<=', now())
            ->update(['status' => 'published']);

        $this->info("Đã xuất bản thành công {$count} bài viết hẹn giờ.");
    }
}