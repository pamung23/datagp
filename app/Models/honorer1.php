<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class honorer1 extends Model
{
    use HasFactory;
    protected $table  = 'honorer1s';

    protected $fillable = [
        'satker_id',
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
