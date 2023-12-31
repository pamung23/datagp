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
        Schema::create('penetapan_k_k3_s', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nomor_sk_parsial');
            $table->date('tanggal_sk_parsial');
            $table->decimal('luas_ha_parsial', 10, 4);
            $table->string('nomor_sk_provinsi');
            $table->date('tanggal_sk_provinsi');
            $table->decimal('luas_ha_provinsi', 10, 4);
            $table->string('nomor_sk_kawasan');
            $table->date('tanggal_sk_kawasan');
            $table->decimal('luas_ha_kawasan', 10, 4);
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
        Schema::dropIfExists('penetapan_k_k3_s');
    }
};
