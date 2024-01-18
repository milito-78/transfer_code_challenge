<?php

use App\Entities\Enums\TransactionStatusEnums;
use App\Infrastructure\Database\Mysql\Models\TransactionStatus;
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
        Schema::create('transaction_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->timestamps();
        });

        TransactionStatus::query()->insert([
            [
                "id" => TransactionStatusEnums::InProgress,
                "title" =>  TransactionStatusEnums::InProgress->name,
            ],
            [
                "id" => TransactionStatusEnums::Success,
                "title" =>  TransactionStatusEnums::Success->name,
            ],
            [
                "id" => TransactionStatusEnums::Failed,
                "title" =>  TransactionStatusEnums::Failed->name,
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_statuses');
    }
};
