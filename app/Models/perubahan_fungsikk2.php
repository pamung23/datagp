<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perubahan_fungsikk2 extends Model
{
    use HasFactory;
    protected $table = 'perubahan_fungsikk2s';

    protected $fillable = [
            'nomor1',
            'tanggal1',
            'luas1',
            'nomor2',
            'tanggal2',
            'luas2',
            'fungsi',
            'nama',
            'luas3',
            'keterangan',
    ];
}
