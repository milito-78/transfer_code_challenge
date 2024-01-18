<?php

namespace App\Services\Users;

use App\Entities\UserCardEntity;
use App\Infrastructure\Repositories\IUserRepository;
use App\Infrastructure\Repositories\ICardRepository;
use App\Entities\UserEntity;

class UserService
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly ICardRepository $cardRepository,
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
        return $this->cardRepository->getByCardNumber($card_number);
    }

}
