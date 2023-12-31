<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kerjasama2 extends Model
{
    use HasFactory;
    protected $table = 'kerjasama2s';

    protected $fillable = [
        'no_register_kawasan',
        'tipe_kerjasama',
        'mitra_kerjasama',
        'judul_kerjasama',
        'ruang_lingkup_kerjasama',
        'nomor_mou',
        'tanggal_mou',
        'tanggal_awal_berlaku',
        'tanggal_akhir_berlaku',
        'keterangan',
    ];
}
