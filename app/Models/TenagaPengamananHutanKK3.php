<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaPengamananHutanKK3 extends Model
{
    use HasFactory;
    protected $table = 'tenaga_pengamanan_hutan_kk3'; // Nama tabel sesuai dengan nama tabel di database
    protected $fillable = [
        'no_register_kawasan',
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
