<?php

namespace App\Infrastructure\Database\Mysql\Models;

use App\Entities\Enums\UserCardStatusEnums;
use App\Entities\UserCardEntity;
use Database\Factories\UserCartFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property int $account_id
 * @property UserAccount $account
 * @property int $status_id,
 * @property UserCardStatusEnums $status,
 * @property string $card_number
 * @property Carbon $expired_at
 * @property Carbon $created_at
 * @property Carbon $updated_at,
 */
class UserCard extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return app()->make(UserCartFactory::class);
    }

    protected $appends = ["status"];
    protected $fillable = ["user_id","account_id" ,"card_number" , "status_id"];

    protected $casts = [
        "expired_at" => "date"
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute() : UserCardStatusEnums
    {
        return UserCardStatusEnums::from($this->status_id);
    }


    public function toEntity() : UserCardEntity
    {
        return new UserCardEntity(
            $this->id,
            $this->user_id,
            $this->account_id,
            $this->card_number,
            $this->status,
            $this->expired_at,
            $this->created_at,
            $this->updated_at,
            $this->relationLoaded("user") ? $this->user->toEntity() : null,
            $this->relationLoaded("account") ? $this->account->toEntity() : null,
        );
    }

    public static function fromEntity(UserCardEntity $entity) : self
    {
        $data               = new self();
        $data->id           = $entity->id;
        $data->user_id      = $entity->user_id;
        $data->account_id   = $entity->account_id;
        $data->card_number  = $entity->card_number;
        $data->status       = $entity->status;
        $data->expired_at   = $entity->expired_at;
        $data->created_at   = $entity->created_at;
        $data->updated_at   = $entity->updated_at;
        return $data;
    }
}
