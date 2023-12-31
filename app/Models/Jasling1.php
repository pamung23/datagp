<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasling1 extends Model
{
    use HasFactory;
    protected $table = 'jasling1s'; // Sesuaikan nama tabel yang sesuai dengan nama tabel yang Anda buat dalam migrasi

    protected $fillable = [
        'no_register_kawasan',
        'iupswa',
        'iupjwa',
        'iupa',
        'iupea',
        'ipa',
        'ipea',
        'ipjlpb_eksplorasi',
        'ipjlpb_eksplorasi_pemanfaatan',
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
