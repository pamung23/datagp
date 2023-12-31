<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenangananPerkara3 extends Model
{
    use HasFactory;
    protected $table = 'penanganan_perkara3s'; // Sesuaikan dengan nama tabel yang sesuai
    protected $fillable = [
        'satker_id',
        'uraian_kasus',
        'tersangka',
        'barang_bukti',
        'lidik',
        'sidik',
        'sp3',
        'p21',
        'vonis',
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
