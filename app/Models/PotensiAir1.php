<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotensiAir1 extends Model
{
    use HasFactory;

    protected $table = 'potensi_air1s'; // Sesuaikan dengan nama tabel Anda

    protected $fillable = [
        'no_register_kawasan',
        'nama_sumber_air',
        'debit',
        'latitude',
        'longitude',
        'massa_air',
        'energi_air',
        'nomor',
        'tanggal',
        'pengusahaan_pihak_iii',
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
