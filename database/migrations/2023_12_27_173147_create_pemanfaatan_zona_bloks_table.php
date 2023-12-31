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
        Schema::create('pemanfaatan_zona_bloks', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nama_kelompok');
            $table->integer('anggota');
            $table->float('luas');
            $table->string('potensi');
            $table->decimal('nilai_ekonomi_per_tahun', 10, 2)->nullable();
            $table->unsignedBigInteger('desa_id');
            $table->foreign('desa_id')->references('id')->on('desas');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemanfaatan_zona_bloks');
    }
};
