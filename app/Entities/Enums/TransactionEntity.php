<?php

namespace App\Entities\Enums;

class TransactionEntity
{
    public function __construct(
        public int $id,
        public int $pure_amount,
        public string $tracking_code,
        public int $fee,
    )
    {
    }
}
