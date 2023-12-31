<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesainTapak extends Model
{
    protected $table = 'desain_tapaks';
    protected $fillable = [
        'no_register_kawasan',
        'nama_zona_blok_pemanfaatan',
        'luas_zona_blok_pemanfaatan',
        'ruang_publik',
        'ruang_usaha',
        'keterangan',
    ];
}
