<?php

namespace App\Infrastructure\Sms\Entities;

class SmsMessage
{
    /**
     * @param string $receptor
     * @param Message $message
     */
    public function __construct(private readonly string $receptor, private readonly Message $message)
    {
    }

    /**
     * @return string
     */
    public function getReceptor(): string
    {
        return $this->receptor;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getRenderedMessage():string
    {
        return $this->message->getContent();
    }
}
