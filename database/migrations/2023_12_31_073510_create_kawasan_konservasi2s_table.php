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
        Schema::create('kawasan_konservasi2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->string('nama_cagar_biosfer');
            $table->string('tahun_penetapan');
            $table->string('area_inti');
            $table->string('zona_penyangga');
            $table->string('area_transisi');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kawasan_konservasi2s');
    }
};
