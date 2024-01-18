<?php

namespace App\Infrastructure\Database\Mysql\Models;

use App\Entities\Enums\UserAccountStatusEnums;
use App\Entities\UserAccountEntity;
use Database\Factories\UserAccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id,
 * @property User $user,
 * @property string $account_number,
 * @property int $status_id,
 * @property UserAccountStatusEnums $status,
 * @property Carbon $created_at,
 * @property Carbon $updated_at,
 */
class UserAccount extends Model
{
    use HasFactory;


    protected static function newFactory()
    {
        return app()->make(UserAccountFactory::class);
    }

    protected $appends = [
        "status"
    ];

    protected $fillable = [
        "id", "user_id" , "account_number", "status_id"
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute() : UserAccountStatusEnums
    {
        return UserAccountStatusEnums::from($this->status_id);
    }


    public function toEntity() : UserAccountEntity
    {
        return new UserAccountEntity(
            $this->id,
            $this->user_id,
            $this->account_number,
            $this->status,
            $this->created_at,
            $this->updated_at,
            $this->relationLoaded("user") ? $this->user : null,
        );
    }

    public static function fromEntity(UserAccountEntity $entity) : self
    {
        $data                   = new self();
        $data->id               = $entity->id;
        $data->user_id          = $entity->user_id;
        $data->account_number   = $entity->account_number;
        $data->status_id        = $entity->status->value;
        $data->created_at       = $entity->created_at;
        $data->updated_at       = $entity->updated_at;
        return $data;
    }
}
