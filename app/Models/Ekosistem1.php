<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekosistem1 extends Model
{
    use HasFactory;
    protected $table = 'ekosistem1s';

    protected $fillable = [
        'no_register_kawasan',
        'tipe',
        'luas',
        'keterangan',
    ];

    protected $casts = [
        'tipe' => 'json',
        'luas' => 'json',
    ];
}
