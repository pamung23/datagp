<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iupjswa2 extends Model
{
    use HasFactory;
    protected $table = 'iupjswa2s';
    protected $fillable = [
        'no_register_kawasan',
        'nama_zona_blok_pemanfaatan',
        'luas_zona_blok_pemanfaatan',
        'iupswa_nama_perusahaan',
        'iupswa_tahun_penerbitan',
        'iupswa_luas_area',
        'iupjwa_nama_pemegang_izin',
        'iupjwa_tahun_penerbitan_izin',
        'iupjwa_jenis_jasa',
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
