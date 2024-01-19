<?php

namespace App\Infrastructure\Sms\Entities;

use App\Infrastructure\Sms\Entities\Enums\MessageEnums;
use Illuminate\Support\Facades\Lang;

class Message
{
    private string $locale;

    /**
     * @param MessageEnums $message
     * @param array<string,mixed> $data
     * @param string|null $locale
     */
    public function __construct(
        public MessageEnums $message,
        public array $data = [],
        ?string $locale = null
    )
    {
        if (!$locale)
            $this->locale = app()->getLocale();
    }

    public function changeLocale(string $locale):self
    {
        $this->locale = $locale;
        return $this;
    }


    public function getContent():string
    {
        if (!Lang::has("sms_message." . $this->message->value,$this->locale))
            logger()->warning("The '{$this->message->value}' message key is not exists in translate files.");

        return __("sms_message." . $this->message->value,$this->data,$this->locale);
    }
}
