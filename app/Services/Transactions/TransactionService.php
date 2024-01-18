<?php

namespace App\Services\Transactions;

use App\Entities\TransactionEntity;
use App\Infrastructure\Repositories\ITransactionRepository;
use Illuminate\Support\Collection;

class TransactionService
{
    public function __construct(
        private readonly ITransactionRepository $transactionRepository
    )
    {
    }

    public function hasEnoughBalanceInAccount(int $account_id, string $amount): bool
    {
        $balance = $this->transactionRepository->getBalanceForAccount($account_id);
        return ($balance - $amount) > 0;
    }

    public function transferAmountByCard(
        int $account_id,
        int $card_id,
        int $destination_account_id,
        int $destination_card_id,
        int $amount
    ) : ?TransactionEntity
    {
        $fee = 500;
        return $this->transactionRepository->createTransferAmountByCard(
            $card_id,
            $account_id,
            $amount,
            $fee,
            $destination_card_id,
            $destination_account_id
        );
    }

    public function getLimitTransactionsForUsers(array $cards,int $limit) : Collection
    {
        return $this->transactionRepository->getTransactionsForUsersLimit($cards,$limit);
    }

}
