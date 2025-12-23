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
        Schema::create('guest_bookings', function (Blueprint $table) {
            $table->increments("id");
            $table->string("guest_number");
            $table->integer("schedule_id")->unsigned();
            $table->integer("departure")->unsigned();
            $table->integer("destination")->unsigned();
            $table->integer("vehicle")->unsigned()->nullable();
            $table->string("vehicle_type");
            $table->date("travel_date");
            $table->string("departure_time");
            $table->string("booking_number")->nullable();
            $table->string("ticket_number")->nullable();
            $table->string("full_name")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("email")->nullable();
            $table->string("gender")->nullable();
            $table->string("nok")->nullable();
            $table->string("nok_phone")->nullable();
            $table->string("seat");
            $table->double("travel_fare", 12, 2);
            $table->enum("payment_channel", ["cash", "card payment", "transfer", "wallet", "pending"]);
            $table->enum("classification", ["booking", "ticketing"]);
            $table->enum("payment_status", ["paid", "pending", "failed", "locked"]);
            $table->enum("booking_method", ["physical", "online"])->default("physical");
            $table->enum("booking_status", ["booked", "validated", "pending", "locked"])->default("booked");
            $table->enum("boarding_status", ["boarded", "pending"])->default("pending");
            $table->timestamp("reservation_date")->nullable();
            $table->timestamps();
            $table->foreign('schedule_id')->references('id')->on('travel_schedules')->onDelete('cascade');
            $table->foreign('departure')->references('id')->on('company_terminals')->onDelete('cascade');
            $table->foreign('destination')->references('id')->on('company_terminals')->onDelete('cascade');
            $table->foreign('vehicle')->references('id')->on('company_vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_bookings');
    }
};
