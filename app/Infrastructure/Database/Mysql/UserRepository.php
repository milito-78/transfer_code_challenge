<?php

namespace App\Infrastructure\Database\Mysql;

use App\Infrastructure\Database\Mysql\Models\User;
use App\Infrastructure\Repositories\IUserRepository;
use App\Entities\UserEntity;
use Illuminate\Database\Eloquent\Builder;

class UserRepository implements IUserRepository
{

    private function query(): Builder
    {
        return User::query();
    }

    public function findUserByMobile(string $mobile): ?UserEntity
    {
        /**
         * @var User $user
         */
        $user = $this->query()->where("mobile", "=", $mobile)->first();

        if (!$user)
            return null;
        return $this->wrapWithEntity($user);
    }

    private function wrapWithEntity(User $user): UserEntity
    {
        return $user->toEntity();
    }
}
