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
        Schema::create('paystack_trxes', function (Blueprint $table) {
            $table->id();
            $table->integer("transaction_id");
            $table->string("reference");
            $table->double("amount");
            $table->enum("trx_type", ["topup", "booking"]);
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
        Schema::dropIfExists('paystack_trxes');
    }
};
