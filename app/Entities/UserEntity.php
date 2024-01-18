<?php

namespace App\Entities;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class UserEntity
{
    public Collection $transactions;
    public Collection $cards;

    public function __construct(
        public int $id,
        public string $name,
        public string $mobile,
        public Carbon $created_at,
        public Carbon $updated_at,
        ?Collection $cards = null,
        ?Collection $transactions = null,
    )
    {
        $this->transactions = $transactions ?: collect();
        $this->cards = $cards ?: collect();
    }

    public function toArray() : array
    {
        return [
            "id"            => $this->id,
            "name"          => $this->name,
            "mobile"        => $this->mobile,
            "transactions"  => $this->transactions->toArray(),
            "cards"         => $this->cards->toArray(),
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at
        ];
    }
}
