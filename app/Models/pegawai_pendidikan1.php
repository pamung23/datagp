<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai_pendidikan1 extends Model
{
    use HasFactory;
    protected $table  = 'pegawai_pendidikan1s';

    protected $fillable = [
        'satker_id',
        'laki_doktor',
        'perempuan_doktor',
        'laki_master',
        'perempuan_master',
        'laki_sarjana',
        'perempuan_sarjana',
        'laki_sarjana_muda',
        'perempuan_sarjana_muda',
        'laki_slta',
        'perempuan_slta',
        'laki_sltp',
        'perempuan_sltp',
        'laki_sd',
        'perempuan_sd',
        'laki_jumlah',
        'perempuan_jumlah',
        'total',
        'keterangan',
    ];
}
