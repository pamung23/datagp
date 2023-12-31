<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fungsional_pendidikan2 extends Model
{
    use HasFactory;
    protected $table  = 'fungsional_pendidikan2s';
    protected $fillable = [
        'satker_id',
        'jenis_jabatan_fungsional',
        'l_s3',
        'p_s3',
        'l_s2',
        'p_s2',
        'l_s1',
        'p_s1',
        'l_d3',
        'p_d3',
        'l_slta',
        'p_slta',
        'l_sltp',
        'p_sltp',
        'l_sd',
        'p_sd',
        'l_jumlah',
        'p_jumlah',
        'total',
        'keterangan',
    ];
}
