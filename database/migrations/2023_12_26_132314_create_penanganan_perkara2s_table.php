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
        Schema::create('penanganan_perkara2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->text('uraian_kasus')->nullable();
            $table->text('tersangka')->nullable();
            $table->text('barang_bukti')->nullable();
            $table->string('lidik')->default('Tidak');
            $table->string('sidik')->default('Tidak');
            $table->string('sp3')->default('Tidak');
            $table->string('p21')->default('Tidak');
            $table->string('vonis')->default('Tidak');
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
        Schema::dropIfExists('penanganan_perkara2s');
    }
};
