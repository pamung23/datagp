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
        Schema::create('peralatan_mesin1s', function (Blueprint $table) {
            $table->id();
            $table->integer('satker_id')->default('239807');
            $table->string('daops');
            $table->integer('baik1');
            $table->integer('rusak1');
            $table->integer('baik2');
            $table->integer('rusak2');
            $table->integer('baik3');
            $table->integer('rusak3');
            $table->integer('baik4');
            $table->integer('rusak4');
            $table->integer('baik5');
            $table->integer('rusak5');
            $table->integer('baik6');
            $table->integer('rusak6');
            $table->integer('baik7');
            $table->integer('rusak7');
            $table->integer('baik8');
            $table->integer('rusak8');
            $table->integer('baik9');
            $table->integer('rusak9');
            $table->integer('baik10');
            $table->integer('rusak10');
            $table->integer('baik11');
            $table->integer('rusak11');
            $table->integer('baik12');
            $table->integer('rusak12');
            $table->integer('baik13');
            $table->integer('rusak13');
            $table->integer('baik14');
            $table->integer('rusak14');
            $table->integer('baik15');
            $table->integer('rusak15');
            $table->string('lain');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peralatan_mesin1s');
    }
};
