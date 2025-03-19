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
        Schema::create('temp_payment_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->integer("file_id")->unsigned();
            $table->string("bank_name")->nullable();
            $table->string("bank_code");
            $table->string("account_name");
            $table->string("account_number");
            $table->string("tracking_code");
            $table->double("amount", 12, 2);
            $table->integer("imported")->default(0);
            $table->text("comment")->nullable();
            $table->timestamps();
            $table->foreign('file_id')->references('id')->on('temp_payment_files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_payment_beneficiaries');
    }
};
