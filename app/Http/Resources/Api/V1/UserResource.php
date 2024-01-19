<?php

namespace App\Http\Resources\Api\V1;

use App\Entities\UserEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var UserEntity $item
         */
        $item = $this->resource;
        return [
            "id"            => $item->id,
            "name"          => $item->name,
            "cards"         => new CardResourceCollection($this->whenNotNull($item->cards)),
            "transactions"  => new TransactionResourceCollection($this->whenNotNull($item->transactions)),
            "created_at"    => resourceDateTimeFormat($item->created_at),
            "updated_at"    => resourceDateTimeFormat($item->updated_at)
        ];
    }
}
