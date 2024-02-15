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
        Schema::create('ultrasonic_data', function (Blueprint $table) {
            $table->string('alamat')->primary();
            $table->string('lat');
            $table->string('lng');
            $table->string('kosong');
            $table->string('setengah');
            $table->string('penuh');
            $table->string('kapasitas_sampah');
            $table->string('kapasitas_mobil');
            $table->string('online');
            $table->string('offline');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ultrasonic_data');
    }
};
