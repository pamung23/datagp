<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemanfaatanAir2 extends Model
{
    use HasFactory;
    protected $table = 'pemanfaatan_air2s';

    protected $fillable = [
        'no_register_kawasan',
        'nama_sumber_air',
        'jenis_izin',
        'nomor_izin',
        'tanggal_izin',
        'nama',
        'alamat_desa_id',
        'lokasi_desa_id',
        'jumlah_dilayani_kk',
        'debit',
        'jumlah_tenaga_kerja',
        'nilai_investasi',
        'keterangan',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
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
