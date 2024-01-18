<?php

namespace App\Infrastructure\Repositories;

use App\Entities\UserCardEntity;
use App\Entities\UserEntity;
use Illuminate\Support\Collection;

interface IUserRepository
{
    /**
     * Find user by mobile
     *
     * @param string $mobile
     * @return UserEntity|null
     */
    public function findUserByMobile(string $mobile): ?UserEntity;

    /**
     * Find user by id
     *
     * @param int $id
     * @return UserEntity|null
     */
    public function findUserById(int $id): ?UserEntity;

    /**
     * Get card by card number
     * @param string $card_number
     * @return UserCardEntity|null
     */
    public function getByCardNumber(string $card_number): ?UserCardEntity;

    /**
     * Get top three
     *
     * @return Collection<UserEntity>
     */
    public function getTopThreeUserTransactor():Collection;
}
