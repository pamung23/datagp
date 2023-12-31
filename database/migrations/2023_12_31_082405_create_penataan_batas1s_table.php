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
        Schema::create('penataan_batas1s', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->integer('p_batas');
            $table->string('tahun');
            $table->integer('panjang');
            $table->integer('jmlh_batas');
            $table->integer('nomor');
            $table->date('tanggal');
            $table->Integer('baik');
            $table->Integer('rusak');
            $table->Integer('hilang');
            $table->Integer('jmlh_pal');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('penataan_batas1s');
    }
};
