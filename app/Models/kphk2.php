<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kphk2 extends Model
{
    use HasFactory;
    protected $table = 'kphk2s'; // Sesuaikan nama tabel yang sesuai dengan nama tabel yang Anda buat dalam migrasi

    protected $fillable = [
        'satker_id',
        'nama',
        'nomor',
        'tanggal',
        'luas',
        'register',
        'keterangan',
    ];
}
