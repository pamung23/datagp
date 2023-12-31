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
        Schema::create('pembinaan_usahas_3', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nama_kelompok');
            $table->integer('anggota')->unsigned();
            $table->string('jenis_kegiatan');
            $table->decimal('jumlah_dana', 15, 2);
            $table->string('sumber_dana');
            $table->string('hasil_manfaat')->nullable();
            $table->string('pendamping');
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
        Schema::dropIfExists('pembinaan_usahas_3');
    }
};
