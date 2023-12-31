<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerencanaanPKK2 extends Model
{
    use HasFactory;
    protected $table = 'perencanaan_pkk2s';

    protected $fillable = [
        'no_register_kawasan',
        'jpan_nomor',
        'jpan_tanggal',
        'jpan_mulai',
        'jpan_akhir',
        'jpen_nomor',
        'jpen_tanggal',
        'jpen_periode',
        'jpen_luas',
        'keterangan',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Isi kolom user_id hanya jika belum diisi
            $model->user_id = $model->user_id ?? auth()->id();
        });
    }
    public function getResortNamaAttribute()
    {
        return optional($this->user->resort)->nama ?? 'Unknown Resort';
    }
}
