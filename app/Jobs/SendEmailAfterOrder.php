<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailAfterOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    /**
     * Create a new job instance.
     */
    public function __construct(protected $view, protected $information, protected $email, protected $subject)
    {
    }
    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::send($this->view, $this->information, function ($message) {
            $message->to($this->email)
                ->from(config('mail.from.address'))
                ->subject($this->subject);
        });
    }
}
