<?php

namespace App\Infrastructure\Sms\Entities\Enums;

enum MessageEnums : string
{
    case IncreasedByCard = "increase_by_card";

    case DecreasedByCard = "decrease_by_card";
}
