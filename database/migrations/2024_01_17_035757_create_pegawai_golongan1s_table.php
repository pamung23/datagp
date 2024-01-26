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
        Schema::create('pegawai_golongan1s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->integer('laki_iv');
            $table->integer('perempuan_iv');
            $table->integer('laki_iii');
            $table->integer('perempuan_iii');
            $table->integer('laki_ii');
            $table->integer('perempuan_ii');
            $table->integer('laki_i');
            $table->integer('perempuan_i');
            $table->integer('laki_jumlah');
            $table->integer('perempuan_jumlah');
            $table->integer('total');
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
        Schema::dropIfExists('pegawai_golongan1s');
    }
};
