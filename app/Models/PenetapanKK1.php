<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenetapanKK1 extends Model
{
    use HasFactory;
    protected $table = 'penetapan_k_k1_s'; // Sesuaikan dengan nama tabel yang Anda gunakan

    protected $fillable = [
        'no_register_kawasan',
        'nomor_sk_parsial',
        'tanggal_sk_parsial',
        'luas_ha_parsial',
        'nomor_sk_provinsi',
        'tanggal_sk_provinsi',
        'luas_ha_provinsi',
        'nomor_sk_kawasan',
        'tanggal_sk_kawasan',
        'luas_ha_kawasan',
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
