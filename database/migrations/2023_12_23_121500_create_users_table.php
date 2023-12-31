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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('hp')->unique();
            $table->enum('blokir', ['Y', 'N'])->default('N');
            $table->enum('level', ['Admin', 'Balai', 'Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor']);
            $table->foreignId('resort_id')->nullable()->constrained('resorts');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
