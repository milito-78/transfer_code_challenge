<?php

namespace App\Infrastructure\Database\Mysql;

use App\Entities\Enums\TransactionStatusEnums;
use App\Entities\Enums\TransactionTypeEnums;
use App\Entities\TransactionEntity;
use App\Infrastructure\Database\Mysql\Models\Transaction;
use App\Infrastructure\Database\Mysql\Models\TransactionFee;
use App\Infrastructure\Repositories\ITransactionRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
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
            $pure_amount = $amount - $fee;
            DB::beginTransaction();
            /**
             * @var Transaction $transaction
             */
            $transaction = $this->query()->create([
                "tracking_code"         => $tracking_code,
                "card_id"               => $card,
                "destination_card_id"   => $dest_card,
                "status_id"             => TransactionStatusEnums::Success->value,
                "amount"                => $amount,
                "pure_amount"           => $pure_amount,
                "fee_amount"            => $fee,
                "type"                  => TransactionTypeEnums::Decrease,
            ]);
            $tracking_code = Str::random() . now()->micro;
            $this->query()->create([
                "tracking_code"         => $tracking_code,
                "card_id"               => $dest_card,
                "status_id"             => TransactionStatusEnums::Success->value,
                "amount"                => $pure_amount,
                "pure_amount"           => $pure_amount,
                "fee_amount"            => 0,
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

    public function getBalanceForAccount($account_id): int
    {
        return $this->query()->where("account_id" ,$account_id)->sum(DB::raw("CAST( amount AS SIGNED ) * type"));
    }

    public function getTransactionsForUsersLimit(array $cards, int $limit): Collection
    {
        $transactions = DB::select("select t.*
            from (select t.*,
                         row_number() over (partition by card_id order by created_at desc) as num
                  from transactions t
                 ) t
            where num <= ? and t.card_id in (?) and reason_id is null;",
            [$limit,implode(",",$cards)]
        );

        $data = collect();
        foreach ($transactions as $transaction){
            $data->push(new TransactionEntity(
                $transaction->id,
                $transaction->amount,
                $transaction->pure_amount,
                $transaction->tracking_code,
                $transaction->card_id,
                $transaction->destination_card_id,
                $transaction->fee_amount,
                TransactionStatusEnums::from($transaction->status_id),
                TransactionTypeEnums::from($transaction->type),
                )
            );
        }


        return $data;
    }

    /**
     * @param Transaction $transaction
     * @return TransactionEntity
     */
    private function wrapWithEntity(Transaction $transaction): TransactionEntity
    {
        return $transaction->toEntity();
    }
}
