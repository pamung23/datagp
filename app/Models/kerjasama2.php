<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kerjasama2 extends Model
{
    use HasFactory;
    protected $table = 'kerjasama2s';

    protected $fillable = [
        'no_register_kawasan',
        'tipe_kerjasama',
        'mitra_kerjasama',
        'judul_kerjasama',
        'ruang_lingkup_kerjasama',
        'nomor_mou',
        'tanggal_mou',
        'tanggal_awal_berlaku',
        'tanggal_akhir_berlaku',
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
