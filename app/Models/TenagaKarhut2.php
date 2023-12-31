<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaKarhut2 extends Model
{
    use HasFactory;
    protected $table = 'tenaga_karhut2s'; // Sesuaikan dengan nama tabel yang telah Anda tentukan di migrasi
    protected $fillable = [
        'satker_id',
        'manggala_agni_pns',
        'manggala_agni_nonpns',
        'jumlah_regu',
        'mpa',
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
