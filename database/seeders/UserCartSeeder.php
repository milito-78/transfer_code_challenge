<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Mysql\Models\UserCart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserCart::factory()->count(10)->create();
    }
}
