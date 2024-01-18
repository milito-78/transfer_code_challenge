<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Mysql\Models\UserCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserCard::factory()->count(10)->create();
    }
}
