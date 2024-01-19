<?php

namespace App\Entities;

use App\Entities\Enums\TransactionStatusEnums;
use App\Entities\Enums\TransactionTypeEnums;
use Illuminate\Support\Carbon;

class TransactionEntity
{
    public function __construct(
        public int $id,
        public int $amount,
        public int $pure_amount,
        public string $tracking_code,
        public int $card_id,
        public ?int $dest_card_id,
        public int $fee,
        public TransactionStatusEnums $status,
        public TransactionTypeEnums $type,
        public Carbon $created_at,
        public Carbon $updated_at,
        public ?UserCardEntity $card = null,
        public ?UserCardEntity $dest_card = null,
    )
    {
    }
}
