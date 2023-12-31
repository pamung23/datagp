<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sarana_pengamatan2 extends Model
{
    use HasFactory;
    protected $table  = 'sarana_pengamatan2s';

    protected $fillable = [
        'satker_id',
        'genggam',
        'laras_panjang',
        'senjata_bius',
        'lain1',
        'mobil',
        'spd_motor',
        'speed_boat',
        'perahu',
        'pesawat',
        'lain2',
        'rick',
        'ht',
        'ssb',
        'lain3',
        'keterangan',
    ];
}
