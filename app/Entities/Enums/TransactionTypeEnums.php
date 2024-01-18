<?php

namespace App\Entities\Enums;

enum TransactionTypeEnums : int
{
    case Decrease = -1;
    case Increase = 1;

}
