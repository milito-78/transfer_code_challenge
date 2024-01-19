<?php

namespace App\Infrastructure\Database\Mysql\Models;

use App\Entities\Enums\TransactionStatusEnums;
use App\Entities\Enums\TransactionTypeEnums;
use App\Entities\TransactionEntity;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $tracking_code
 * @property int $card_id
 * @property int $destination_card_id
 * @property int $status_id
 * @property TransactionStatusEnums $status
 * @property TransactionTypeEnums $type
 * @property int $amount
 * @property int $pure_amount
 * @property int $fee_amount
 * @property string $reason_id
 * @property ?Transaction $reason
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Transaction extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return app()->make(TransactionFactory::class);
    }

    protected $appends = [
        "status"
    ];

    protected $casts = [
      "type" => TransactionTypeEnums::class,
    ];

    protected $fillable = [
        "tracking_code",
        "card_id",
        "destination_card_id",
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
            $this->destination_card_id,
            $this->fee_amount,
            $this->status,
            $this->type
        );
    }

}
