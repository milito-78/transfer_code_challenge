<?php

namespace App\Entities\Enums;

enum TransactionStatusEnums : int
{
    case InProgress = 1;
    case Success = 2;
    case Failed = 3;

}
