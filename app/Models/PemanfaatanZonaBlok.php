<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemanfaatanZonaBlok extends Model
{
    protected $table = 'pemanfaatan_zona_bloks';

    protected $fillable = [
        'no_register_kawasan',
        'id_desa',
        'nama_kelompok',
        'anggota',
        'luas',
        'potensi',
        'nilai_ekonomi_per_tahun',
        'keterangan',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }
}
