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
        Schema::create('desain_tapaks', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nama_zona_blok_pemanfaatan');
            $table->decimal('luas_zona_blok_pemanfaatan', 10, 2);
            $table->decimal('ruang_publik', 10, 2);
            $table->decimal('ruang_usaha', 10, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desain_tapaks');
    }
};
