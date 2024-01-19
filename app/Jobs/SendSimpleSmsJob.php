<?php

namespace App\Jobs;

use App\Infrastructure\Sms\Entities\SmsMessage;
use App\Infrastructure\Sms\Interfaces\Sender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSimpleSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly SmsMessage $message)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(Sender $sender): void
    {
        $sender->send($this->message);
    }
}
