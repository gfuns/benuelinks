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
        Schema::create('rerouting_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("previous_schedule_id")->unsigned();
            $table->integer("new_schedule_id")->unsigned();
            $table->integer("ticketer")->unsigned();
            $table->string("customer_name");
            $table->string("previous_seat");
            $table->string("new_seat");
            $table->timestamps();
            $table->foreign('ticketer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('previous_schedule_id')->references('id')->on('travel_schedules')->onDelete('cascade');
            $table->foreign('new_schedule_id')->references('id')->on('travel_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rerouting_transactions');
    }
};
