<?php

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
        Schema::create('user_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")
                ->on("users")
                ->references("id");
            $table->unsignedBigInteger('account_id');
            $table->foreign("account_id")
                ->on("user_accounts")
                ->references("id");

            $table->string("card_number")->unique();

            $table->unsignedBigInteger('status_id');
            $table->foreign("status_id")
                ->on("user_carts_statuses")
                ->references("id");

            $table->timestamp("expired_at");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_carts');
    }
};
