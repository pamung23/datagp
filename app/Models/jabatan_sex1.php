<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jabatan_sex1 extends Model
{
    use HasFactory;
    protected $table  = 'jabatan_sex1s';

    protected $fillable = [
        'satker_id',
        'laki_ia',
        'perempuan_ia',
        'laki_ib',
        'perempuan_ib',
        'laki_iia',
        'perempuan_iia',
        'laki_iib',
        'perempuan_iib',
        'laki_iiia',
        'perempuan_iiia',
        'laki_iiib',
        'perempuan_iiib',
        'laki_iiic',
        'perempuan_iiic',
        'laki_iiid',
        'perempuan_iiid',
        'laki_iva',
        'perempuan_iva',
        'laki_ivb',
        'perempuan_ivb',
        'laki_umum',
        'perempuan_umum',
        'laki_tertentu',
        'perempuan_tertentu',
        'laki_jumlah',
        'perempuan_jumlah',
        'total',
        'keterangan',
    ];
}
