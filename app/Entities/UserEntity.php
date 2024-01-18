<?php

namespace App\Entities;

use Illuminate\Support\Carbon;

class UserEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public string $mobile,
        public Carbon $created_at,
        public Carbon $updated_at,
    )
    {
    }

    public function toArray() : array
    {
        return [
            "id"            => $this->id,
            "name"          => $this->name,
            "mobile"        => $this->mobile,
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at
        ];
    }
}
