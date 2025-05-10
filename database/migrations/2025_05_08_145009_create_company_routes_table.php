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
        Schema::create('company_routes', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("departure")->unsigned();
            $table->integer("destination")->unsigned();
            $table->double("transport_fare", 12, 2);
            $table->enum("status", ["active", "suspended"])->default("active");
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
        Schema::dropIfExists('company_routes');
    }
};
