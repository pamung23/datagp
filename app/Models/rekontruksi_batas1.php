<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rekontruksi_batas1 extends Model
{
    use HasFactory;
    protected $table = 'rekontruksi_batas1s';

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
