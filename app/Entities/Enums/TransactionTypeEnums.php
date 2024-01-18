<?php

namespace App\Entities\Enums;

enum TransactionTypeEnums : string
{
    case Decrease = "-1";
    case Increase = "1";

}
