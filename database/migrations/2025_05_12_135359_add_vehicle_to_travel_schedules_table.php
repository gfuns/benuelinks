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
        Schema::table('travel_schedules', function (Blueprint $table) {
            $table->integer("vehicle")->unsigned()->nullable();
            $table->foreign('vehicle')->references('id')->on('company_vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_schedules', function (Blueprint $table) {
            $table->dropColumn('vehicle');
        });
    }
};
