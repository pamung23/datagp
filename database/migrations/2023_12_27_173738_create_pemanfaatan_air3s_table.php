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
        Schema::create('pemanfaatan_air3s', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nama_sumber_air');
            $table->string('jenis_izin');
            $table->string('nomor_izin');
            $table->date('tanggal_izin');
            $table->string('nama');
            $table->integer('jumlah_dilayani_kk');
            $table->decimal('debit', 10, 2);
            $table->integer('jumlah_tenaga_kerja');
            $table->decimal('nilai_investasi', 18, 2);
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('desa_id');
            $table->foreign('desa_id')->references('id')->on('desas');
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
        Schema::dropIfExists('pemanfaatan_air3s');
    }
};
