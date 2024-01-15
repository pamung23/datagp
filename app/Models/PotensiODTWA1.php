<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotensiODTWA1 extends Model
{
    use HasFactory;
    protected $table = 'potensi_odtwa1';

    protected $fillable = [
        'no_register_kawasan',
        'nama_zona_blok_pemanfaatan',
        'luas_zona_blok_pemanfaatan',
        'jenis_odtwa',
        'latitude',
        'longitude',
        'jenis_atraksi_wisata',
        'jenis_prasarana',
        'jumlah_unit',
        'kondisi',
        'pengusahaan_oleh_pihak_iii',
        'keterangan',
    ];

    protected $casts = [
        'jenis_prasarana' => 'json',
        'jumlah_unit' => 'json',
        'kondisi' => 'json',
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
