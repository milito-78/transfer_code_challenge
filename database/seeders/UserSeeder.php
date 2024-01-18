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
        $first = User::query()->create([
            'name'              => "first user",
            'mobile'            => "091422222222",
            'password' => bcrypt("password"),
        ]);

        //Seed second user
        $second = User::query()->create([
            'name'              => "second user",
            'mobile'            => "091411111111",
            'password' => bcrypt("password_2"),
        ]);
    }
}
