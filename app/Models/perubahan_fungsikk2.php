<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perubahan_fungsikk2 extends Model
{
    use HasFactory;
    protected $table = 'perubahan_fungsikk2s';

    protected $fillable = [
        'nomor1',
        'tanggal1',
        'luas1',
        'nomor2',
        'tanggal2',
        'luas2',
        'fungsi',
        'nama',
        'luas3',
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
