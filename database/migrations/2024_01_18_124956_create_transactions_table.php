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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("tracking_code")->unique();

            $table->unsignedBigInteger('card_id');
            $table->foreign("card_id")
                ->on("user_cards")
                ->references("id");

            $table->unsignedBigInteger('destination_card_id')->nullable();
            $table->foreign("destination_card_id")
                ->on("user_cards")
                ->references("id");

            $table->unsignedBigInteger('status_id');
            $table->foreign("status_id")
                ->on("user_cards_statuses")
                ->references("id");

            $table->integer("type")->default(1)->comment("-1,1");

            $table->unsignedBigInteger("amount");
            $table->unsignedBigInteger("pure_amount");
            $table->bigInteger("fee_amount")->default(0);

            $table->unsignedBigInteger("reason_id")->nullable();
            $table->foreign("reason_id")
                ->on("transactions")
                ->references("id");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
