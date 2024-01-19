<?php

namespace App\Http\Resources\Api\V1;

use App\Entities\UserCardEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var UserCardEntity $item
         */
        $item = $this->resource;
        return [
            "id"            => $item->id,
            "card_number"   => $item->card_number,
            "status_id"     => $item->status->value,
            "status_label"  => $item->status->name,
            "expired_at"    => resourceDateTimeFormat($item->expired_at)
        ];
    }
}
