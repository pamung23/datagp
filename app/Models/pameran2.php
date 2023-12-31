<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pameran2 extends Model
{
    use HasFactory;
    protected $table = 'pameran2s'; // Sesuaikan nama tabel yang sesuai dengan nama tabel yang Anda buat dalam migrasi

    protected $fillable = [
        'satker_id',
        'jenis',
        'judul',
        'penyelenggara',
        'sumber',
        'keterangan',
    ];
}
