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
        Schema::create('company_vehicles', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("driver")->unsigned()->nullable();
            $table->string("vehicle_number");
            $table->string("plate_number");
            $table->string("chassis_number");
            $table->string("engine_number");
            $table->string("manufacturer");
            $table->string("model");
            $table->string("year");
            $table->string("color");
            $table->integer("seats");
            $table->string("display_photo")->nullable();
            $table->enum("status", ["active", "under maintenance", "decommissioned", "sold"])->default("active");
            $table->timestamps();
            $table->foreign('driver')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_vehicles');
    }
};
