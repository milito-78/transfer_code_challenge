<?php

namespace App\Infrastructure\Database\Mysql\Models;

use App\Entities\Enums\UserAccountStatusEnums;
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

}
