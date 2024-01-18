<?php

namespace App\Infrastructure\Database\Mysql;

use App\Entities\UserCardEntity;
use App\Infrastructure\Database\Mysql\Models\UserCard;
use Illuminate\Database\Eloquent\Builder;

class CardRepository implements \App\Infrastructure\Repositories\ICardRepository
{
    private function query(): Builder
    {
        return UserCard::query();
    }

    /**
     * @inheritDoc
     */
    public function getByCardNumber(string $card_number): ?UserCardEntity
    {
        /**
         * @var UserCard $card
         */
        $card = $this->query()->where("card_number" , "=" ,$card_number)->with(["user","account"])->first();

        if (!$card)
            return null;
        return $this->wrapWithEntity($card);
    }


    /**
     * @param UserCard $card
     * @return UserCardEntity
     */
    private function wrapWithEntity(UserCard $card): UserCardEntity
    {
        return $card->toEntity();
    }
}
