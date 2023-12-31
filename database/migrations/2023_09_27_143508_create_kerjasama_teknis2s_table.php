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
        Schema::create('kerjasama_teknis2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->string('mitra_kerja');
            $table->string('tipe_mitra');
            $table->string('jenis_kerja_sama');
            $table->string('judul_kerja_sama');
            $table->string('ruang_lingkup_kerja_sama');
            $table->string('no_mou_pks');
            $table->date('tanggal_mou_pks');
            $table->string('persetujuan_kerja_sama');
            $table->date('tanggal_awal_berlaku');
            $table->date('tanggal_akhir_berlaku');
            $table->string('lokasi_kerja_konservasi');
            $table->string('lokasi_kerja_provinsi');
            $table->string('luas_areal_kerja_sama');
            $table->string('komitmen_pendanaan');
            $table->string('ikp_ikk_berkaitan');
            $table->string('status_kerja_sama');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerjasama_teknis2s');
    }
};
