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
        Schema::create('pegawai_pendidikan1s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->integer('laki_doktor');
            $table->integer('perempuan_doktor');
            $table->integer('laki_master');
            $table->integer('perempuan_master');
            $table->integer('laki_sarjana');
            $table->integer('perempuan_sarjana');
            $table->integer('laki_sarjana_muda');
            $table->integer('perempuan_sarjana_muda');
            $table->integer('laki_slta');
            $table->integer('perempuan_slta');
            $table->integer('laki_sltp');
            $table->integer('perempuan_sltp');
            $table->integer('laki_sd');
            $table->integer('perempuan_sd');
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
        Schema::dropIfExists('pegawai_pendidikan1s');
    }
};
