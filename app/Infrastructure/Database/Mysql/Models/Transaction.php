<?php

namespace App\Infrastructure\Database\Mysql\Models;

use App\Entities\Enums\TransactionStatusEnums;
use App\Entities\Enums\TransactionTypeEnums;
use App\Entities\TransactionEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $appends = [
        "status"
    ];
    protected $casts = [
      "type" => TransactionTypeEnums::class,
    ];

    protected $fillable = [
        "tracking_code",
        "card_id",
        "account_id",
        "destination_card_id",
        "destination_account_id",
        "status_id",
        "type",
        "amount",
        "pure_amount",
        "fee_amount",
        "reason_id",
    ];


    public function getStatusAttribute() : TransactionStatusEnums
    {
        return TransactionStatusEnums::from($this->status_id);
    }

    public function toEntity() : TransactionEntity
    {
        return new TransactionEntity(
            $this->id,
            $this->amount,
            $this->pure_amount,
            $this->tracking_code,
            $this->card_id,
            $this->account_id,
            $this->destination_card_id,
            $this->fee_amount,
            $this->status,
            $this->type
        );
    }

}
