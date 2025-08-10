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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('last_name');
            $table->string('other_names');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('bvn')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('referral_channel')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('referral_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('wallet_pin')->nullable();
            $table->double('wallet_balance', 12, 2)->default(0.00);
            $table->string('nok')->nullable();
            $table->string('nok_name')->nullable();
            $table->integer('role_id')->unsigned();
            $table->integer('station')->unsigned()->nullable();
            $table->enum("status", ["active", "suspended", "banned"])->default("active");
            $table->string('token')->nullable();
            $table->string('bankOneCustomerId')->nullable();
            $table->string('bankOneBankId')->nullable();
            $table->string('bankOneAccountNumber')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->foreign('station')->references('id')->on('company_terminals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
