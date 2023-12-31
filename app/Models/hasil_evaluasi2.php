<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hasil_evaluasi2 extends Model
{
    use HasFactory;
    protected $table = 'hasil_evaluasi2s';

    protected $fillable = [
        'no_register_kawasan',
        'tanggal',
        'rekomendasi',
        'tindak',
        'keterangan',
    ];
}
