<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lkkhusus4 extends Model
{
    use HasFactory;
    protected $table = 'lkkhusus4s';

    protected $fillable = [
        'satker_id',
        'bentuk_lk',
        'nama_lk',
        'alamat_lk',
        'provinsi',
        'latitude',
        'longitude',
        'luas_areal_hektar',
        'nomor',
        'tanggal',
        'masa_berlaku_tahun',
        'nama_ilmiah',
        'jantan',
        'betina',
        'belum_diketahui',
        'jumlah',
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
