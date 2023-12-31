<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaerahPenyangga extends Model
{
    protected $table = 'daerah_penyanggas';

    protected $fillable = [
        'id_desa',
        'no_register_kawasan',
        'keterangan',
    ];
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }
}
