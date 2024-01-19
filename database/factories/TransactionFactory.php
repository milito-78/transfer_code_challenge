<?php

namespace Database\Factories;

use App\Entities\Enums\TransactionStatusEnums;
use App\Infrastructure\Database\Mysql\Models\Transaction;
use App\Infrastructure\Database\Mysql\Models\UserCard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "tracking_code"         => fake()->unique()->regexify('[A-Za-z0-9]{20}'),
            "card_id"               => UserCard::query()->inRandomOrder()->first()->id,
            "destination_card_id"   => UserCard::query()->inRandomOrder()->first()->id,
            "status_id"             => TransactionStatusEnums::Success,
            "type"                  => $this->faker->randomElement([-1,1]),
            "amount"                => $this->faker->randomDigitNotZero(),
            "pure_amount"           => $this->faker->randomDigitNotZero(),
            "fee_amount"            => $this->faker->randomDigit(),
        ];
    }
}
