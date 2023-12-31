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
        Schema::create('perubahan_fungsikk2s', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->integer('nomor1');
            $table->date('tanggal1');
            $table->integer('luas1');
            $table->integer('nomor2');
            $table->date('tanggal2');
            $table->integer('luas2');
            $table->integer('fungsi');
            $table->string('nama');
            $table->integer('luas3');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perubahan_fungsikk2s');
    }
};
