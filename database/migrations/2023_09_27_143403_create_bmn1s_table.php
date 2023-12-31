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
        Schema::create('bmn1s', function (Blueprint $table) {
                $table->id();
                $table->integer('satker_id')->default('239807');
                $table->integer('kode');
                $table->integer('uraian');
                $table->integer('satuan');
                $table->integer('kuantitas1');
                $table->integer('nilai1');
                $table->integer('kuantitas2');
                $table->integer('nilai2');
                $table->integer('kuantitas3');
                $table->integer('nilai3');
                $table->integer('kuantitas4');
                $table->integer('nilai4');
                $table->string('keterangan')->nullable();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bmn1s');
    }
};
