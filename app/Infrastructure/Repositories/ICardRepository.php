<?php

namespace App\Infrastructure\Repositories;

use App\Entities\UserCardEntity;

interface ICardRepository
{
    /**
     * Get card by card number
     * @param string $card_number
     * @return UserCardEntity|null
     */
    public function getByCardNumber(string $card_number): ?UserCardEntity;
}
