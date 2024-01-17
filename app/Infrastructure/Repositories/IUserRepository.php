<?php

namespace App\Infrastructure\Repositories;

use App\Entities\UserEntity;

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
}
