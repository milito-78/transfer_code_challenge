<?php

namespace Database\Factories;

use App\Entities\Enums\UserAccountStatusEnums;
use App\Infrastructure\Database\Mysql\Models\User;
use App\Infrastructure\Database\Mysql\Models\UserAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<UserAccount>
 */
class UserAccountFactory extends Factory
{
    protected $model = UserAccount::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id"           => User::query()->inRandomOrder()->first()->id,//TODO handle user relation
            "account_number"    => $this->faker->iban("IR"),
            "status_id"         => UserAccountStatusEnums::Active->value,
        ];
    }
}
