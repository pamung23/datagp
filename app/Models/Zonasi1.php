<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonasi1 extends Model
{
    use HasFactory;
    protected $table = 'zonasi1s';

    protected $fillable = [
        'no_register_kawasan',
        'nomor',
        'tanggal',
        'inti',
        'rimba',
        'pemanfaatan',
        'perlindungan',
        'perlindungan_bahari',
        'rehabilitasi',
        'tradisional',
        'religi',
        'khusus',
        'koleksi',
        'lainnya',
        'total',
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
