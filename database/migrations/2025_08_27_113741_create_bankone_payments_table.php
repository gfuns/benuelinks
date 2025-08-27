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
        Schema::create('bankone_payments', function (Blueprint $table) {
            $table->id();
            $table->integer("transaction_id");
            $table->string("reference");
            $table->double("amount");
            $table->string("account_number");
            $table->string("account_name");
            $table->string("bank");
            $table->enum("trx_type", ["topup", "booking", "guest"]);
            $table->enum("status", ["pending", "successful", "failed"]);
            $table->integer("handled")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankone_payments');
    }
};
