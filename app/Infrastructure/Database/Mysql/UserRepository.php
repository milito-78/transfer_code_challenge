<?php

namespace App\Infrastructure\Database\Mysql;

use App\Entities\UserCardEntity;
use App\Infrastructure\Database\Mysql\Models\User;
use App\Infrastructure\Database\Mysql\Models\UserCard;
use App\Infrastructure\Repositories\IUserRepository;
use App\Entities\UserEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserRepository implements IUserRepository
{

    private function query(): Builder
    {
        return User::query();
    }

    private function cardQuery(): Builder{
        return UserCard::query();
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function findUserById(int $id): ?UserEntity
    {
        /**
         * @var User $user
         */
        $user = $this->query()->where("id", "=", $id)->first();

        if (!$user)
            return null;
        return $this->wrapWithEntity($user);
    }

    /**
     * @inheritDoc
     */
    public function getByCardNumber(string $card_number): ?UserCardEntity
    {
        /**
         * @var UserCard $card
         */
        $card = $this->cardQuery()->where("card_number" , "=" ,$card_number)->with(["user","account"])->first();

        if (!$card)
            return null;
        return $this->wrapWithCardEntity($card);
    }

    public function getTopThreeUserTransactor(): Collection
    {
        $result = $this->cardQuery()
            ->selectRaw("user_id, GROUP_CONCAT(transactions.card_id) AS concatenated_card_ids, count(transactions.id) as tr_count")
            ->join("transactions","transactions.card_id","=","user_cards.id")
            ->groupByRaw("user_cards.user_id")
            ->whereNull("transactions.reason_id")
            ->orderBy("tr_count","desc")
            ->where("transactions.created_at" , ">=" ,now()->subMinutes(1000))
            ->limit(3)
            ->with("user")
            ->get();

        $data = collect();

        $result->each(function (UserCard $card) use($data){
            $entity = $this->wrapWithEntity($card->user);
            $entity->cards = collect(explode(",",$card->concatenated_card_ids));
            $data->add($entity);
        });

        return $data;
    }


    /**
     * @param Collection<UserCard> $entities
     * @return Collection
     */
    public function wrapWithCardsCollectionEntity(Collection $entities) : Collection
    {
        return $entities->map(function (UserCard $card){
            return $card->toEntity();
        });
    }

    /**
     * @param UserCard $entity
     * @return UserCardEntity
     */
    public function wrapWithCardEntity(UserCard $entity) : UserCardEntity
    {
        return $entity->toEntity();
    }

    /**
     * @param User $user
     * @return UserEntity
     */
    private function wrapWithEntity(User $user): UserEntity
    {
        return $user->toEntity();
    }
}
