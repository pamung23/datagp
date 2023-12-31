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
        Schema::create('fungsional_sex2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->integer('laki_peh');
            $table->integer('perempuan_peh');
            $table->integer('laki_polhut');
            $table->integer('perempuan_polhut');
            $table->integer('laki_penyuluh');
            $table->integer('perempuan_penyuluh');
            $table->integer('laki_pranata');
            $table->integer('perempuan_pranata');
            $table->integer('laki_statistisi');
            $table->integer('perempuan_statistisi');
            $table->integer('laki_analis');
            $table->integer('perempuan_analis');
            $table->integer('laki_arsiparis');
            $table->integer('perempuan_arsiparis');
            $table->integer('laki_perencana');
            $table->integer('perempuan_perencana');
            $table->integer('laki_pengadaan');
            $table->integer('perempuan_pengadaan');
            $table->integer('laki_jumlah');
            $table->integer('perempuan_jumlah');
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
        Schema::dropIfExists('fungsional_sex2s');
    }
};
