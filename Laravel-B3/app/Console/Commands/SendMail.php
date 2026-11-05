<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Mail;

use App\Mail\VerifyEmail;

use Illuminate\Console\Command;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mail {email} {--bcc=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail to email address';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $bcc = $this->option('bcc');

        $send = Mail::to($email);
        if(!empty($bcc)) {
            $send->bcc($bcc);
        }
        $send->send(new VerifyEmail('Thảo'));
        $this->info('Mail send to ' . $email . ' with bcc: ' . $bcc ??'');
        return Command::SUCCESS;
    }
}
