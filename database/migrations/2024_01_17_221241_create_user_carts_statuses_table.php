<?php

use App\Entities\Enums\UserCartStatusEnums;
use App\Infrastructure\Database\Mysql\Models\UserCartStatus;
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
        Schema::create('user_carts_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->timestamps();
        });

        UserCartStatus::query()->insert([
            [
                "id" => UserCartStatusEnums::Active,
                "title" =>  UserCartStatusEnums::Active->name,
            ],
            [
                "id" => UserCartStatusEnums::InActive,
                "title" =>  UserCartStatusEnums::InActive->name,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_carts_statuses');
    }
};
