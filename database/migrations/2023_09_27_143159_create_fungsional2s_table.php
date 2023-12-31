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
        Schema::create('fungsional2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->string('peh');
            $table->integer('jumlah_peh');
            $table->string('polhut');
            $table->integer('jumlah_polhut');
            $table->string('penyuluh');
            $table->integer('jumlah_penyuluh');
            $table->string('pranata');
            $table->integer('jumlah_pranata');
            $table->string('statis');
            $table->integer('jumlah_statis');
            $table->string('analisis');
            $table->integer('jumlah_analisis');
            $table->string('arsiparis');
            $table->integer('jumlah_arsiparis');
            $table->string('perencanana');
            $table->integer('jumlah_perencanana');
            $table->string('pengadaan');
            $table->integer('jumlah_pengadaan');
            $table->integer('total');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fungsional2s');
    }
};
