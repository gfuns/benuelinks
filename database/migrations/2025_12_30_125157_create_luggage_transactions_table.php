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
        Schema::create('luggage_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->unsigned();
            $table->integer("booking_id")->unsigned();
            $table->integer("terminal_id")->unsigned();
            $table->string("ticket_number");
            $table->string("luggage_weight");
            $table->double("fee", 12, 2);
            $table->enum("payment_channel", ["cash", "card payment", "transfer"]);
            $table->enum("payment_status", ["paid", "pending", "failed"])->default("pending");
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('travel_bookings')->onDelete('cascade');
            $table->foreign('terminal_id')->references('id')->on('company_terminals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luggage_transactions');
    }
};
