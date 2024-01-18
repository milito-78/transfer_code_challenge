<?php

namespace App\Entities;

use App\Entities\Enums\UserCardStatusEnums;
use Illuminate\Support\Carbon;

class UserCardEntity
{
    public function __construct(
        public int                 $id,
        public int                 $user_id,
        public int                 $account_id,
        public string              $card_number,
        public UserCardStatusEnums $status,
        public Carbon              $expired_at,
        public Carbon              $created_at,
        public Carbon              $updated_at,
        public ?UserEntity         $user = null,
        public ?UserAccountEntity  $account = null,
    )
    {
    }

    public function toArray() : array
    {
        return [
            "id"            => $this->id,
            "user_id"       => $this->user_id,
            "user"          => $this->user ? $this->user->toArray():[],
            "account_id"    => $this->account_id,
            "account"       => $this->account ? $this->account->toArray() : [],
            "status"        => $this->status->value,
            "status_text"   => $this->status->name,
            "expired_at"    => $this->expired_at,
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at
        ];
    }
}
