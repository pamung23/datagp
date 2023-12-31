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
        Schema::create('fungsional_pendidikan1s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->string('jenis_jabatan_fungsional');
            $table->integer('l_s3');
            $table->integer('p_s3');
            $table->integer('l_s2');
            $table->integer('p_s2');
            $table->integer('l_s1');
            $table->integer('p_s1');
            $table->integer('l_d3');
            $table->integer('p_d3');
            $table->integer('l_slta');
            $table->integer('p_slta');
            $table->integer('l_sltp');
            $table->integer('p_sltp');
            $table->integer('l_sd');
            $table->integer('p_sd');
            $table->integer('l_jumlah');
            $table->integer('p_jumlah');
            $table->integer('total');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fungsional_pendidikan1s');
    }
};
