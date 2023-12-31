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
        Schema::create('iupjswa4s', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nama_zona_blok_pemanfaatan');
            $table->decimal('luas_zona_blok_pemanfaatan', 10, 2);
            $table->string('iupswa_nama_perusahaan');
            $table->integer('iupswa_tahun_penerbitan');
            $table->decimal('iupswa_luas_area', 10, 2);
            $table->string('iupjwa_nama_pemegang_izin');
            $table->integer('iupjwa_tahun_penerbitan_izin');
            $table->string('iupjwa_jenis_jasa');
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
        Schema::dropIfExists('iupjswa4s');
    }
};
