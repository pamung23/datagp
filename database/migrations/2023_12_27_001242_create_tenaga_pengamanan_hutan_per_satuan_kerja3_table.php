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
        Schema::create('tenaga_pengamanan_hutan_per_satuan_kerja3', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->integer('polhut');
            $table->integer('ppns');
            $table->integer('tphl');
            $table->integer('mmp');
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
        Schema::dropIfExists('tenaga_pengamanan_hutan_per_satuan_kerja3');
    }
};
