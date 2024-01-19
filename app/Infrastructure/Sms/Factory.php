<?php

namespace App\Infrastructure\Sms;

use App\Infrastructure\Sms\Exceptions\ConfigException;
use App\Infrastructure\Sms\Exceptions\SmsDriverException;
use App\Infrastructure\Sms\Interfaces\Sender;
use Illuminate\Contracts\Container\BindingResolutionException;

class Factory
{

    /**
     * @throws ConfigException
     */
    public function __construct(public array $config = [])
    {
        $this->checkConfigs();
    }


    /**
     * @throws ConfigException
     */
    private function checkConfigs(): void
    {
        $this->config = count($this->config) ? $this->config : config("sms");
        if (!key_exists("drivers" ,$this->config) || !count($this->config["drivers"]))
            throw new ConfigException("drivers key not exists in config file.");
    }
    /**
     * @param ?string $driver
     * @return Sender
     * @throws SmsDriverException|BindingResolutionException
     */
    public function create(?string $driver = null) : Sender
    {
        if (!$driver)
            $found = $this->config["drivers"][$this->config["default"]];
        else
            $found = $this->config["drivers"][$driver];

        if (!$found || !$found["class"])
            throw new SmsDriverException("Unknown driver called '$driver'");
        $class = $found["class"];
        unset($found["class"]);

        return app()->make($class , ["config" => $found]);
    }

}
