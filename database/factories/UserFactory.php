<?php

namespace Database\Factories;

use App\Infrastructure\Database\Mysql\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->name(),
            'mobile'        => fake()->unique()->phoneNumber(),
            'password'      => Hash::make('password'),
            'remember_token'=> Str::random(10),
        ];
    }

}
