<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai_golongan1 extends Model
{
    use HasFactory;
    protected $table  = 'pegawai_golongan1s';

    protected $fillable = [
        'satker_id',
        'laki_iv',
        'perempuan_iv',
        'laki_iii',
        'perempuan_iii',
        'laki_ii',
        'perempuan_ii',
        'laki_i',
        'perempuan_i',
        'laki_jumlah',
        'perempuan_jumlah',
        'total',
        'keterangan',
    ];
}
