<?php

namespace App\Http\Resources\Api\V1;

use App\Entities\TransactionEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var TransactionEntity $item
         */
        $item = $this->resource;

        return  [
            "id"                  => $item->id,
            "card_id"             => $item->card_id,
            "card"                => new CardResource($this->whenNotNull($item->card)),
            "destination_card_id" => $item->dest_card_id,
            "destination_card"    => new CardResource($this->whenNotNull($item->dest_card)),
            "amount"              => $item->amount,
            "pure_amount"         => $item->pure_amount,
            "fee"                 => $item->fee,
            "tracking_code"       => $item->tracking_code,
            "status_id"           => $item->status->value,
            "status_label"        => $item->status->name,
            "type_id"             => $item->type->value,
            "type_label"          => $item->type->name,
            "created_at"          => resourceDateTimeFormat($item->created_at),
            "updated_at"          => resourceDateTimeFormat($item->updated_at),
        ];
    }
}
