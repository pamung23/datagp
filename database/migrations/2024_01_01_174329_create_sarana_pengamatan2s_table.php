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
        Schema::create('sarana_pengamatan2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('100242015');
            $table->integer('genggam');
            $table->integer('laras_panjang');
            $table->integer('senjata_bius');
            $table->integer('lain1');
            $table->integer('mobil');
            $table->integer('spd_motor');
            $table->integer('speed_boat');
            $table->integer('perahu');
            $table->integer('pesawat');
            $table->integer('lain2');
            $table->integer('rick');
            $table->integer('ht');
            $table->integer('ssb');
            $table->integer('lain3');
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
        Schema::dropIfExists('sarana_pengamatan2s');
    }
};
