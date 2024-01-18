<?php

namespace Database\Factories;

use App\Entities\Enums\UserCardStatusEnums;
use App\Infrastructure\Database\Mysql\Models\UserAccount;
use App\Infrastructure\Database\Mysql\Models\UserCard;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<UserCard>
 */
class UserCartFactory extends Factory
{
    protected $model = UserCard::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /**
         * @var UserAccount $account
         */
        $account = UserAccount::query()->inRandomOrder()->first();

        return [
            "user_id"           => $account->user_id,
            "account_id"        => $account->id,
            "card_number"       => $this->faker->creditCardNumber(),
            "expired_at"        => Carbon::now()->addYears(),
            "status_id"         => UserCardStatusEnums::Active->value,
        ];
    }
}
