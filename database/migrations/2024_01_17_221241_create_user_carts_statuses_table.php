<?php

use App\Entities\Enums\UserCardStatusEnums;
use App\Infrastructure\Database\Mysql\Models\UserCardStatus;
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
        Schema::create('user_cards_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->timestamps();
        });

        UserCardStatus::query()->insert([
            [
                "id" => UserCardStatusEnums::Active,
                "title" =>  UserCardStatusEnums::Active->name,
            ],
            [
                "id" => UserCardStatusEnums::InActive,
                "title" =>  UserCardStatusEnums::InActive->name,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cards_statuses');
    }
};
