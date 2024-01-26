<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pameran1 extends Model
{
    use HasFactory;
    protected $table = 'pameran1s'; // Sesuaikan nama tabel yang sesuai dengan nama tabel yang Anda buat dalam migrasi

    protected $fillable = [
        'satker_id',
        'jenis',
        'judul',
        'penyelenggara',
        'sumber',
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
