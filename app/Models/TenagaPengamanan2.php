<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaPengamanan2 extends Model
{
    use HasFactory;
    protected $table = 'tenaga_pengamana2';

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
