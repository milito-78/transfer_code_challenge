<?php

namespace App\Infrastructure\Sms\Interfaces;

use App\Infrastructure\Sms\Entities\SmsMessage;

interface Sender
{
    /**
     * @param SmsMessage $message
     * @return mixed
     */
    public function send(SmsMessage $message): bool;
}
