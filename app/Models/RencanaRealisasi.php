<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaRealisasi extends Model
{
    protected $fillable = [
        'nomor_register',
        'kawasan_konservasi',
        'sumber_pembiayaan',
        'keterangan',
        'metode_pe',
        'target_ha',
        'luas_ha',
        'persentase_keberhasilan',
    ];
}
