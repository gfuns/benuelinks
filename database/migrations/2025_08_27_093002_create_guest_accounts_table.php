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
        Schema::create('guest_accounts', function (Blueprint $table) {
            $table->increments("id");
            $table->string('last_name');
            $table->string('other_names');
            $table->string('email');
            $table->string('phone_number');
            $table->string('gender');
            $table->date('dob');
            $table->string('bvn');
            $table->string('contact_address')->nullable();
            $table->string('account_number');
            $table->string('bank_name')->default("Peace Microfinace Bank");
            $table->string('bankOneCustomerId')->nullable();
            $table->string('bankOneBankId')->nullable();
            $table->string('bankOneAccountNumber')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_accounts');
    }
};
