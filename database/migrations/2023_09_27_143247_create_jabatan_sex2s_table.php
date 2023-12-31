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
        Schema::create('jabatan_sex2s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('36');
            $table->integer('laki_ia');
            $table->integer('perempuan_ia');
            $table->integer('laki_ib');
            $table->integer('perempuan_ib');
            $table->integer('laki_iia');
            $table->integer('perempuan_iia');
            $table->integer('laki_iib');
            $table->integer('perempuan_iib');
            $table->integer('laki_iiia');
            $table->integer('perempuan_iiia');
            $table->integer('laki_iiib');
            $table->integer('perempuan_iiib');
            $table->integer('laki_iiic');
            $table->integer('perempuan_iiic');
            $table->integer('laki_iiid');
            $table->integer('perempuan_iiid');
            $table->integer('laki_iva');
            $table->integer('perempuan_iva');
            $table->integer('laki_ivb');
            $table->integer('perempuan_ivb');
            $table->integer('laki_umum');
            $table->integer('perempuan_umum');
            $table->integer('laki_tertentu');
            $table->integer('perempuan_tertentu');
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
        Schema::dropIfExists('jabatan_sex2s');
    }
};
