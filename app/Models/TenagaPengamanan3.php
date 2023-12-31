<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaPengamanan3 extends Model
{
    use HasFactory;
    protected $table = 'tenaga_pengamanan3';

    protected $fillable = [
        'satker_id',
        'polhut',
        'ppns',
        'tphl',
        'mmp',
        'keterangan',
        // Kolom lainnya sesuai kebutuhan
    ];
}
