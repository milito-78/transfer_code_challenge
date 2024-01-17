<?php

namespace App\Services\Users;

use App\Infrastructure\Repositories\IUserRepository;
use App\Entities\UserEntity;

class UserService
{
    public function __construct(
        private readonly IUserRepository $userRepository
    )
    {
    }


    /**
     * Get user by mobile
     * @param string $mobile
     * @return UserEntity|null
     */
    public function getUserByMobile(string $mobile): ?UserEntity
    {
        return $this->userRepository->findUserByMobile($mobile);
    }


    /**
     * Get user by id
     * @param int $id
     * @return UserEntity|null
     */
    public function getUserById(int $id) :  ?UserEntity
    {
        return $this->userRepository->findUserById($id);
    }


}
