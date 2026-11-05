<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function build()
    {
        return $this->subject('Bài viết của bạn có bình luận mới!')
                    ->view('emails.comment_notification');
    }
}