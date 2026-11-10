<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Carbon\Carbon;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Tự động chuyển trạng thái các bài viết hẹn giờ đã đến hạn sang đã đăng';

    public function handle()
    {
        $now = Carbon::now();

        $count = Post::where('status', 'scheduled')
            ->where('post_date', '<=', $now)
            ->update(['status' => 'published']);

        $this->info("Đã xuất bản thành công {$count} bài viết hẹn giờ.");
    }
}