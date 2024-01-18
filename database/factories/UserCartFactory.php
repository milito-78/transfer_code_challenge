<?php

namespace Database\Factories;

use App\Entities\Enums\UserCartStatusEnums;
use App\Infrastructure\Database\Mysql\Models\UserAccount;
use App\Infrastructure\Database\Mysql\Models\UserCart;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<UserCart>
 */
class UserCartFactory extends Factory
{
    protected $model = UserCart::class;

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
            "cart_number"       => $this->faker->creditCardNumber(),
            "expired_at"        => Carbon::now()->addYears(),
            "status_id"         => UserCartStatusEnums::Active->value,
        ];
    }
}
