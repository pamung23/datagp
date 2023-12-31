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
        Schema::create('lkkhusus4s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->string('bentuk_lk');
            $table->string('nama_lk');
            $table->string('alamat_lk');
            $table->string('provinsi');
            $table->double('latitude', 10, 6); // Koordinat lintang dengan 6 angka di belakang koma
            $table->double('longitude', 10, 6); // Koordinat bujur dengan 6 angka di belakang koma
            $table->double('luas_areal_hektar', 10, 2);
            $table->string('nomor'); // Kolom untuk Nomor (mungkin tipe string, tergantung pada format Nomor)
            $table->date('tanggal'); // Kolom untuk Tanggal (tipe data tanggal)
            $table->integer('masa_berlaku_tahun'); // Kolom untuk Masa Berlaku dalam tahun (tipe data integer)
            $table->string('nama_ilmiah'); // Kolom untuk Nama Ilmiah (tipe data string)
            $table->integer('jantan'); // Kolom untuk Jantan (tipe data integer)
            $table->integer('betina'); // Kolom untuk Betina (tipe data integer)
            $table->integer('belum_diketahui'); // Kolom untuk Belum Diketahui (tipe data integer)
            $table->integer('jumlah'); // Kolom untuk Jumlah (tipe data integer)
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
        Schema::dropIfExists('lkkhusus4s');
    }
};
