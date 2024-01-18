<?php

namespace App\Entities;

use App\Entities\Enums\UserAccountStatusEnums;
use Illuminate\Support\Carbon;

class UserAccountEntity
{
    public function __construct(
        public int $id,
        public int $user_id,
        public string $account_number,
        public UserAccountStatusEnums $status,
        public Carbon $created_at,
        public Carbon $updated_at,
        public ?UserEntity $user = null,
    )
    {
    }

    public function toArray() : array
    {
        return [
            "id"            => $this->id,
            "user_id"       => $this->id,
            "account_number"=> $this->id,
            "status"        => $this->status->value,
            "status_text"   => $this->status->name,
            "user"          => $this->user ? $this->user->toArray() : [],
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at
        ];
    }
}
