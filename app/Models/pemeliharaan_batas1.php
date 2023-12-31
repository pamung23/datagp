<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemeliharaan_batas1 extends Model
{
    use HasFactory;
    protected $table = 'pemeliharaan_batas1s';

    protected $fillable = [
        'no_register_kawasan',
        'p_batas',
        'tahun',
        'panjang',
        'jmlh_batas',
        'nomor',
        'tanggal',
        'keterangan',
    ];
}
