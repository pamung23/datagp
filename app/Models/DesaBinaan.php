<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesaBinaan extends Model
{
    use HasFactory;
    protected $fillable = ['id_desa', 'no_register_kawasan', 'nama_kelompok', 'keterangan'];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }
}
