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
        Schema::create('xtrapay_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string("event");
            $table->string("reference");
            $table->double("amount", 12, 2)->nullable();
            $table->string("account_number");
            $table->string("account_name");
            $table->string("status");
            $table->string("source_account_number")->nullable();
            $table->string("source_account_name")->nullable();
            $table->string("source_bank")->nullable();
            $table->text("narration")->nullable();
            $table->string("session_id")->nullable();
            $table->string("settlement_id")->nullable();
            $table->longText("payload");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xtrapay_webhooks');
    }
};
