<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fungsional_sex2 extends Model
{
    use HasFactory;
    protected $table  = 'fungsional_sex2s';

    protected $fillable = [
        'satker_id',
        'laki_peh',
        'perempuan_peh',
        'laki_polhut',
        'perempuan_polhut',
        'laki_penyuluh',
        'perempuan_penyuluh',
        'laki_pranata',
        'perempuan_pranata',
        'laki_statistisi',
        'perempuan_statistisi',
        'laki_analis',
        'perempuan_analis',
        'laki_arsiparis',
        'perempuan_arsiparis',
        'laki_perencana',
        'perempuan_perencana',
        'laki_pengadaan',
        'perempuan_pengadaan',
        'laki_jumlah',
        'perempuan_jumlah',
        'total',
        'keterangan',
    ];
}
