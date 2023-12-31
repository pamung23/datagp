<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KemitraanKonservasi extends Model
{
    use HasFactory;
    protected $table = 'kemitraan_konservasis';
    protected $fillable = [
        'no_register_kawasan',
        'desa_id',
        'nama_kelompok',
        'jumlah_anggota',
        'luas_pks',
        'zona_blok',
        'bentuk_kemitraan',
        'nilai_ekonomi_per_tahun',
        'keterangan',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
