<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonasi1 extends Model
{
    use HasFactory;
    protected $table = 'zonasi1s';

    protected $fillable = [
        'no_register_kawasan',
        'nomor',
        'tanggal',
        'inti',
        'rimba',
        'pemanfaatan',
        'perlindungan',
        'perlindungan_bahari',
        'rehabilitasi',
        'tradisional',
        'religi',
        'khusus',
        'koleksi',
        'lainnya',
        'total',
        'keterangan',
    ];
}
