<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sarana_pengamatan2 extends Model
{
    use HasFactory;
    protected $table  = 'sarana_pengamatan2s';

    protected $fillable = [
        'satker_id',
        'genggam',
        'laras_panjang',
        'senjata_bius',
        'lain1',
        'mobil',
        'spd_motor',
        'speed_boat',
        'perahu',
        'pesawat',
        'lain2',
        'rick',
        'ht',
        'ssb',
        'lain3',
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
