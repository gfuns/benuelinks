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
        Schema::create('platform_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("configuration_name");
            $table->double("value", 12, 2);
            $table->enum("metric", ["flat", "percentage"]);
            $table->enum("type", ["luggage", "discount"]);
            $table->enum("payment_channel", ["cash", "card payment", "transfer"]);
            $table->timestamps();
        });
    }

/**
 * Reverse the migrations.
 */
    public function down(): void
    {
        Schema::dropIfExists('platform_configs');
    }
};
