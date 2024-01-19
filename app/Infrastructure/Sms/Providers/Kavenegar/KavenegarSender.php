<?php

namespace App\Infrastructure\Sms\Providers\Kavenegar;

use App\Infrastructure\Sms\Entities\SmsMessage;
use App\Infrastructure\Sms\Interfaces\Sender;
use ArrayAccess;
use Illuminate\Support\Arr;
use Kavenegar\KavenegarApi;

class KavenegarSender implements Sender
{

    private readonly KavenegarApi $client;

    /**
     * @param array<string,mixed> $config
     */
    public function __construct(private readonly array $config = [])
    {
        $this->client = new KavenegarApi($this->getConfig("api_key"),$this->getConfig("insecure")??false);
    }


    /**
     * @param SmsMessage $message
     * @return bool
     */
    public function send(SmsMessage $message): bool
    {
        try {
            $this->client->Send($this->getConfig("sender_number"),$message->getReceptor(),$message->getRenderedMessage());

            return true;
        } catch (\Kavenegar\Exceptions\ApiException $exception) {
            logError($exception,"KavenegarSender Failed : " . $exception->getMessage());
            return false;
        }
    }


    /**
     * @param string|null $option
     * @return array|ArrayAccess|mixed
     */
    protected function getConfig(?string $option = null): mixed{
        return Arr::get($this->config, $option);
    }
}
