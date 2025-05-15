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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("user_id")->unsigned();
            $table->enum("trx_type", ["credit", "debit"]);
            $table->string("reference");
            $table->double("amount", 12, 2);
            $table->double("balance_before", 12, 2);
            $table->double("balance_after", 12, 2);
            $table->text("description");
            $table->enum("status", ["pending", "successful", "failed"])->default("pending");
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
