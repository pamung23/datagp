<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemeliharaan_batas1 extends Model
{
    use HasFactory;
    protected $table = 'pemeliharaan_batas1s';

    protected $fillable = [
        'no_register_kawasan',
        'p_batas',
        'tahun',
        'panjang',
        'jmlh_batas',
        'nomor',
        'tanggal',
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
