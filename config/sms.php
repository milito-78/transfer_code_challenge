<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Default Driver
   |--------------------------------------------------------------------------
   |
   | Default drivers called kavenegar,ghasedak
   |
   */
    "default" => env("SMS_PROVIDER_DEFAULT","kavenegar"),

    "drivers" => [
        "kavenegar" => [
            "class"         => \App\Infrastructure\Sms\Providers\Kavenegar\KavenegarSender::class,
            "api_key"       => env("KAVENEGAR_API_KEY"),
            "sender_number" => env("KAVENEGAR_SENDER_NUMBER"),
        ],
        "ghasedak" => [
            "class"         => \App\Infrastructure\Sms\Providers\Ghasedak\GhasedakSender::class,
            "api_key"       => env("GHASEDAK_API_KEY"),
            "sender_number" => env("GHASEDAK_SENDER_NUMBER"),
        ],
    ],

];
