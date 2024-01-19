<?php

namespace App\Infrastructure\Sms\Providers\Ghasedak;

use App\Infrastructure\Sms\Entities\SmsMessage;
use App\Infrastructure\Sms\Interfaces\Sender;
use ArrayAccess;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Throwable;

class GhasedakSender implements Sender
{

    const PATH = "https://api.ghasedak.me/v2/";

    /**
     * @param array<string,mixed> $config
     */
    public function __construct(private readonly array $config = [])
    {
    }


    /**
     * @param SmsMessage $message
     * @return bool
     */
    public function send(SmsMessage $message): bool
    {
        try {
            $data = [
                "message"       => $message->getRenderedMessage(),
                "receptor"      => $message->getReceptor(),
                "linenumber"    => $this->getConfig('sender_number')
            ];

            $response = Http::withHeaders([
                    "apikey" => $this->getConfig('api_key'),
                ])->asForm()
                ->post($this->getPath("sms/send/simple"), $data);

            $response->throw();

            if ($response->successful())
                return true;

            return false;
        }catch (RequestException  $exception){
            logError($exception,"Request failed in GhasedakSender : " . $exception->getMessage());
            return false;
        }
        catch (Throwable $exception) {
            logError($exception,"GhasedakSender Failed : " . $exception->getMessage());
            return false;
        }

    }


    /**
     * @param string $path
     * @return string
     */
    private function getPath(string $path): string
    {
        return self::PATH . $path;
    }

    /**
     * @param string|null $option
     * @return array|ArrayAccess|mixed
     */
    protected function getConfig(?string $option = null): mixed{
        return Arr::get($this->config, $option);
    }
}
