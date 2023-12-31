<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kawasan_konservasi1 extends Model
{
    use HasFactory;
    protected $table  = 'kawasan_konservasi1s';

    protected $fillable = [
        'satker_id',
        'nama_cagar_biosfer',
        'tahun_penetapan',
        'area_inti',
        'zona_penyangga',
        'area_transisi',
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
