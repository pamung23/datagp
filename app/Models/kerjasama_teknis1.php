<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kerjasama_teknis1 extends Model
{
    use HasFactory;
    protected $table = 'kerjasama_teknis1s'; // Nama tabel yang sesuai dengan yang Anda buat dalam migrasi

    protected $fillable = [
        'mitra_kerja',
        'satker_id',
        'tipe_mitra',
        'jenis_kerja_sama',
        'judul_kerja_sama',
        'ruang_lingkup_kerja_sama',
        'no_mou_pks',
        'tanggal_mou_pks',
        'persetujuan_kerja_sama',
        'tanggal_awal_berlaku',
        'tanggal_akhir_berlaku',
        'lokasi_kerja_konservasi',
        'lokasi_kerja_provinsi',
        'luas_areal_kerja_sama',
        'komitmen_pendanaan',
        'ikp_ikk_berkaitan',
        'status_kerja_sama',
        'keterangan',
    ];
}
