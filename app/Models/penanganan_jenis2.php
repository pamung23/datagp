<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penanganan_jenis2 extends Model
{
    use HasFactory;
    protected $table = 'penanganan_jenis1s';

    protected $fillable = [
        'no_register_kawasan',
        'ilmiah',
        'luas',
        'latitude',
        'longitude',
        'penanganan',
        'rencana',
        'kemitraan',
        'keterangan',
    ];
}
