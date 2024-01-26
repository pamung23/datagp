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
        Schema::create('fungsional2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->integer('calon_terampil_peh');
            $table->integer('terampil_peh');
            $table->integer('calon_ahli_peh');
            $table->integer('ahli_peh');
            $table->integer('jumlah_peh');
            $table->integer('calon_terampil_polhut');
            $table->integer('terampil_polhut');
            $table->integer('calon_ahli_polhut');
            $table->integer('ahli_polhut');
            $table->integer('jumlah_polhut');
            $table->integer('calon_terampil_penyuluh');
            $table->integer('terampil_penyuluh');
            $table->integer('calon_ahli_penyuluh');
            $table->integer('ahli_penyuluh');
            $table->integer('jumlah_penyuluh');
            $table->integer('calon_terampil_pranata');
            $table->integer('terampil_pranata');
            $table->integer('calon_ahli_pranata');
            $table->integer('ahli_pranata');
            $table->integer('jumlah_pranata');
            $table->integer('calon_terampil_statis');
            $table->integer('terampil_statis');
            $table->integer('calon_ahli_statis');
            $table->integer('ahli_statis');
            $table->integer('jumlah_statis');
            $table->integer('calon_terampil_analisis');
            $table->integer('terampil_analisis');
            $table->integer('calon_ahli_analisis');
            $table->integer('ahli_analisis');
            $table->integer('jumlah_analisis');
            $table->integer('calon_terampil_arsiparis');
            $table->integer('terampil_arsiparis');
            $table->integer('calon_ahli_arsiparis');
            $table->integer('ahli_arsiparis');
            $table->integer('jumlah_arsiparis');
            $table->integer('calon_terampil_perencana');
            $table->integer('terampil_perencana');
            $table->integer('calon_ahli_perencana');
            $table->integer('ahli_perencana');
            $table->integer('jumlah_perencana');
            $table->integer('calon_terampil_pengadaan');
            $table->integer('terampil_pengadaan');
            $table->integer('calon_ahli_pengadaan');
            $table->integer('ahli_pengadaan');
            $table->integer('jumlah_pengadaan');
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
        Schema::dropIfExists('fungsional2s');
    }
};
