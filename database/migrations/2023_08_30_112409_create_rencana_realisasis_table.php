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
        Schema::create('rencana_realisasis', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('metode_pe');
            $table->decimal('target_ha', 10, 2);
            $table->decimal('luas_ha', 10, 2);
            $table->decimal('persentase_keberhasilan', 5, 2)->nullable();
            $table->string('sumber_pembiayaan');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_realisasis');
    }
};
