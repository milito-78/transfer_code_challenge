<?php

namespace App\Infrastructure\Repositories;


use App\Entities\TransactionEntity;

interface ITransactionRepository
{

    /**
     * @param $card
     * @param $account
     * @param $amount
     * @param $fee
     * @param $dest_card
     * @param $dest_account
     * @return TransactionEntity|null
     */
    public function createTransferAmountByCard($card, $account, $amount, $fee, $dest_card, $dest_account): ?TransactionEntity;


    public function getBalanceForAccount($account_id):int;
}
