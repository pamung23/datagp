<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fungsional2 extends Model
{
    use HasFactory;
    protected $table = 'fungsional2s';

    protected $fillable = [
        'satker_id',
        'peh',
        'jumlah_peh',
        'polhut',
        'jumlah_polhut',
        'penyuluh',
        'jumlah_penyuluh',
        'pranata',
        'jumlah_pranata',
        'statis',
        'jumlah_statis',
        'analisis',
        'jumlah_analisis',
        'arsiparis',
        'jumlah_arsiparis',
        'perencanana',
        'jumlah_perencanana',
        'pengadaan',
        'jumlah_pengadaan',
        'total',
        'keterangan',
    ];
}
