<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->string('meter_id');
            $table->float('voltage1')->nullable();
            $table->float('voltage2')->nullable();
            $table->float('voltage3')->nullable();
            $table->float('current1')->nullable();
            $table->float('current2')->nullable();
            $table->float('current3')->nullable();
            $table->float('power1')->nullable();
            $table->float('power2')->nullable();
            $table->float('power3')->nullable();
            $table->float('energy')->nullable();
            $table->float('frequency')->nullable();
            $table->float('power_factor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};