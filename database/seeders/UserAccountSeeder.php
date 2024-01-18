<?php

namespace Database\Seeders;

use App\Infrastructure\Database\Mysql\Models\UserAccount;
use Illuminate\Database\Seeder;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserAccount::factory()->count(10)->create();
    }
}
