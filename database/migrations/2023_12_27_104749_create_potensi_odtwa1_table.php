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
        Schema::create('potensi_odtwa1', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nama_zona_blok_pemanfaatan');
            $table->decimal('luas_zona_blok_pemanfaatan', 10, 2);
            $table->string('jenis_odtwa');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('jenis_atraksi_wisata');
            $table->json('jenis_prasarana'); // JSON data type
            $table->json('jumlah_unit'); // JSON data type
            $table->json('kondisi');
            $table->string('pengusahaan_oleh_pihak_iii');
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
        Schema::dropIfExists('potensi_odtwa1');
    }
};
