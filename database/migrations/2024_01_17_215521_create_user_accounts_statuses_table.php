<?php

use App\Entities\Enums\UserAccountStatusEnums;
use App\Infrastructure\Database\Mysql\Models\UserAccountStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_accounts_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->timestamps();
        });

        UserAccountStatus::query()->insert([
            [
               "id" => UserAccountStatusEnums::Active,
               "title" =>  UserAccountStatusEnums::Active->name,
            ],
            [
                "id" => UserAccountStatusEnums::Blocked,
                "title" =>  UserAccountStatusEnums::Blocked->name,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_accounts_statuses');
    }
};
