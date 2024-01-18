<?php

namespace App\Infrastructure\Database\Mysql;

use App\Entities\Enums\TransactionStatusEnums;
use App\Entities\Enums\TransactionTypeEnums;
use App\Entities\TransactionEntity;
use App\Infrastructure\Database\Mysql\Models\Transaction;
use App\Infrastructure\Database\Mysql\Models\TransactionFee;
use App\Infrastructure\Repositories\ITransactionRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionRepository implements ITransactionRepository
{

    private function query(): Builder
    {
        return Transaction::query();
    }


    public function createTransferAmountByCard($card,$account,$amount,$fee,$dest_card,$dest_account): ?TransactionEntity
    {
        try {
            $tracking_code = Str::random() . now()->micro;

            DB::beginTransaction();
            $transaction = $this->query()->create([
                "tracking_code"         => $tracking_code,
                "card_id"               => $card,
                "account_id"            => $account,
                "destination_card_id"   => $dest_card,
                "status_id"             => TransactionStatusEnums::Success->value,
                "amount"                => $amount,
                "pure_amount"           => $amount - $fee,
                "fee_amount"            => $fee,
                "type"                  => TransactionTypeEnums::Decrease,
            ]);
            $tracking_code = Str::random() . now()->micro;
            $this->query()->create([
                "tracking_code"         => $tracking_code,
                "card_id"               => $dest_card,
                "account_id"            => $dest_account,
                "destination_card_id"   => $card,
                "status_id"             => TransactionStatusEnums::Success->value,
                "amount"                => $amount,
                "pure_amount"           => $amount - $fee,
                "fee_amount"            => $fee,
                "reason_id"             => $transaction->id,
                "type"                  => TransactionTypeEnums::Increase,
            ]);
            TransactionFee::query()->create([
                "transaction_id" => $transaction->id,
                "amount" => $fee
            ]);
            DB::commit();
            return $this->wrapWithEntity($transaction);
        }catch (\Exception $exception){
            DB::rollBack();
            logger()->error("Error during transaction : ".$exception->getMessage(),["context" => $exception]);
            return null;
        }
    }

    /**
     * @param Transaction $transaction
     * @return TransactionEntity
     */
    private function wrapWithEntity(Transaction $transaction): TransactionEntity
    {
        return $transaction->toEntity();
    }

    public function getBalanceForAccount($account_id): int
    {
        return $this->query()->where("account_id" ,$account_id)->sum(DB::raw("CAST( amount AS SIGNED ) * type"));
    }
}
