<?php

namespace App\Services\Transactions;

use App\Entities\Enums\TransactionEntity;

class TransactionService
{
    public function hasEnoughInAccount(int $account_id, string $amount): bool
    {
        //TODO transaction service
        return true;
    }

    public function transferAmountByCard(
        int $account_id,
        int $card_id,
        int $destination_account_id,
        int $destination_card_id,
        int $amount
    ) : object
    {
        $fee = 500;
        return new TransactionEntity(1,$amount - $fee,"tracking_code", $fee);
    }

}
