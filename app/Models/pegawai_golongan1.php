<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai_golongan1 extends Model
{
    use HasFactory;
    protected $table  = 'pegawai_golongan1s';

    protected $fillable = [
        'satker_id',
        'laki_iv',
        'perempuan_iv',
        'laki_iii',
        'perempuan_iii',
        'laki_ii',
        'perempuan_ii',
        'laki_i',
        'perempuan_i',
        'laki_jumlah',
        'perempuan_jumlah',
        'total',
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
