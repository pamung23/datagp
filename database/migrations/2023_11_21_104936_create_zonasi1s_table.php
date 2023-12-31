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
        Schema::create('zonasi1s', function (Blueprint $table) {
            $table->id();
            $table->integer('no_register_kawasan')->default('100242015');
            $table->string('nomor');
            $table->date('tanggal');
            $table->decimal('inti', 10, 2);
            $table->decimal('rimba', 10, 2);
            $table->decimal('pemanfaatan', 10, 2);
            $table->decimal('perlindungan', 10, 2);
            $table->decimal('perlindungan_bahari', 10, 2);
            $table->decimal('rehabilitasi', 10, 2);
            $table->decimal('tradisional', 10, 2);
            $table->decimal('religi', 10, 2);
            $table->decimal('khusus', 10, 2);
            $table->decimal('koleksi', 10, 2);
            $table->decimal('lainnya', 10, 2);
            $table->decimal('total', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zonasi1s');
    }
};
