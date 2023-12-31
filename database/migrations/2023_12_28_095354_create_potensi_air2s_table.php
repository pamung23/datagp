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
        Schema::create('potensi_air2s', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nama_sumber_air');
            $table->decimal('debit', 10, 4);
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 11, 6);
            $table->decimal('massa_air', 10, 4);
            $table->decimal('energi_air', 10, 4);
            $table->string('nomor');
            $table->date('tanggal');
            $table->string('pengusahaan_pihak_iii');
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
        Schema::dropIfExists('potensi_air2s');
    }
};
