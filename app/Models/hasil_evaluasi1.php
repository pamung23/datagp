<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hasil_evaluasi1 extends Model
{
    use HasFactory;
    protected $table = 'hasil_evaluasi1s';

    protected $fillable = [
        'no_register_kawasan',
        'tanggal',
        'rekomendasi',
        'tindak',
        'keterangan',
    ];
}
