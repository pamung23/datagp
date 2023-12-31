<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaPengamananHutanPerSatuanKerja2 extends Model
{
    use HasFactory;
    protected $table = 'tenaga_pengamanan_hutan_per_satuan_kerja2'; // Nama tabel sesuai dengan nama tabel di database

    protected $fillable = [
        'satker_id',
        'polhut',
        'ppns',
        'tphl',
        'mmp',
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
