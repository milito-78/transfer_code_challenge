<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Mysql\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Seed first user
        User::query()->create([
            'name'              => "first user",
            'mobile'            => "09360875937",
            'password' => bcrypt("password"),
        ]);

        //Seed second user
        User::query()->create([
            'name'              => "second user",
            'mobile'            => "09148449105",
            'password' => bcrypt("password_2"),
        ]);
    }
}
