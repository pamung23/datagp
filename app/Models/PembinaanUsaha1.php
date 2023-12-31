<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembinaanUsaha1 extends Model
{
    use HasFactory;
    protected $table = 'pembinaan_usahas_1';

    // Define kolom-kolom yang digunakan dalam triwulan 1
    protected $fillable = [
        'no_register_kawasan',
        'nama_kelompok',
        'anggota',
        'jenis_kegiatan',
        'jumlah_dana',
        'sumber_dana',
        'hasil_manfaat',
        'pendamping',
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
