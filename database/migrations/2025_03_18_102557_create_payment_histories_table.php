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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("file_id")->unsigned()->nullable();
            $table->string("bank_name");
            $table->string("bank_code");
            $table->string("account_name");
            $table->string("account_number");
            $table->double("amount", 12, 2);
            $table->string("recipient_code")->nullable();
            $table->string("reference")->nullable();
            $table->string("narration")->nullable();
            $table->enum("trx_type", ["single", "bulk"]);
            $table->enum("status", ["pending", "validating account details", "processing payment", "payment successful", "payment failed"]);
            $table->integer("uploaded")->default(0);
            $table->string("remark")->nullable();
            $table->integer("user_id")->unsigned();
            $table->enum("channel", ["web", "api"])->default("web");
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
