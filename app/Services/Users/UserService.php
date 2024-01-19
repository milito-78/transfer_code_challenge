<?php

namespace App\Services\Users;

use App\Entities\TransactionEntity;
use App\Entities\UserCardEntity;
use App\Infrastructure\Repositories\IUserRepository;
use App\Entities\UserEntity;
use App\Infrastructure\Sms\Entities\Enums\MessageEnums;
use App\Infrastructure\Sms\Entities\Message;
use App\Infrastructure\Sms\Entities\SmsMessage;
use App\Jobs\SendSimpleSmsJob;
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


    public function sendTransferCardSmsToUsers(TransactionEntity $transaction, UserEntity $origin, UserEntity $dest)
    {
        try {
            SendSimpleSmsJob::dispatch(
                new SmsMessage(
                    $origin->mobile,
                    new Message(MessageEnums::DecreasedByCard,[
                        "amount" => $transaction->amount,
                        "tracking_code" => $transaction->tracking_code
                    ])
                )
            )->onQueue("send_sms"); //We can set queue name inside job class.
        }catch (\Throwable $exception){
            logError($exception);
        }

        try {
            SendSimpleSmsJob::dispatch(
                new SmsMessage(
                    $dest->mobile,
                    new Message(MessageEnums::IncreasedByCard,[
                        "amount" => $transaction->amount,
                    ])
                )
            )->onQueue("send_sms"); //We can set queue name inside job class.
        }catch (\Throwable $exception){
            logError($exception,step: "#2");
        }
    }
}
