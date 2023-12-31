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
        Schema::create('pameran1s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->string('jenis');
            $table->string('judul');
            $table->string('penyelenggara');
            $table->string('sumber');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pameran1s');
    }
};
