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
        Schema::create('travel_schedules', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("departure")->unsigned();
            $table->integer("destination")->unsigned();
            $table->date("scheduled_date");
            $table->string("scheduled_time")->default("06:30 AM");
            $table->enum("status", ["scheduled", "trip suspended", "boarding in progress", "in transit", "trip successful"])->default("scheduled");
            $table->timestamps();
            $table->foreign('departure')->references('id')->on('company_terminals')->onDelete('cascade');
            $table->foreign('destination')->references('id')->on('company_terminals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_schedules');
    }
};
