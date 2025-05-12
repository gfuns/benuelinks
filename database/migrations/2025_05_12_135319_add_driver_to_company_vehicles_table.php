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
        Schema::table('company_vehicles', function (Blueprint $table) {
            $table->integer("driver")->unsigned()->nullable();
            $table->foreign('driver')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_vehicles', function (Blueprint $table) {
            $table->dropColumn('driver');
        });
    }
};
