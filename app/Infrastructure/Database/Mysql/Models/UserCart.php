<?php

namespace App\Infrastructure\Database\Mysql\Models;

use App\Entities\Enums\UserCartStatusEnums;
use App\Entities\UserCartEntity;
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
 * @property UserCartStatusEnums $status,
 * @property string $cart_number
 * @property Carbon $expired_at
 * @property Carbon $created_at
 * @property Carbon $updated_at,
 */
class UserCart extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return app()->make(UserCartFactory::class);
    }

    protected $appends = ["status"];
    protected $fillable = ["user_id","account_id" ,"cart_number" , "status_id"];

    public function account(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute() : UserCartStatusEnums
    {
        return UserCartStatusEnums::from($this->status_id);
    }


    public function toEntity() : UserCartEntity
    {
        return new UserCartEntity(
            $this->id,
            $this->user_id,
            $this->account_id,
            $this->cart_number,
            $this->status,
            $this->expired_at,
            $this->created_at,
            $this->updated_at,
            $this->relationLoaded("user") ? $this->user : null,
            $this->relationLoaded("account") ? $this->account : null,
        );
    }

    public static function fromEntity(UserCartEntity $entity) : self
    {
        $data               = new self();
        $data->id           = $entity->id;
        $data->user_id      = $entity->user_id;
        $data->account_id   = $entity->account_id;
        $data->cart_number  = $entity->cart_number;
        $data->status       = $entity->status;
        $data->expired_at   = $entity->expired_at;
        $data->created_at   = $entity->created_at;
        $data->updated_at   = $entity->updated_at;
        return $data;
    }
}
