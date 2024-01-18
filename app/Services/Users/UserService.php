<?php

namespace App\Services\Users;

use App\Entities\UserCardEntity;
use App\Infrastructure\Repositories\IUserRepository;
use App\Entities\UserEntity;
use Illuminate\Support\Collection;

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


    /**
     * Get user by id
     * @param string $card_number
     * @return UserCardEntity|null
     */
    public function getCardByCardNumber(string $card_number): ?UserCardEntity
    {
        return $this->userRepository->getByCardNumber($card_number);
    }

    /**
     * Get top three users transactor in system
     * @return Collection
     */
    public function getTopThreeUser(): Collection
    {
        return $this->userRepository->getTopThreeUserTransactor();
    }

}
