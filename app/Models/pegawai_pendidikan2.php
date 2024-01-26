<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai_pendidikan2 extends Model
{
    use HasFactory;
    protected $table = 'pegawai_pendidikan2s';

    protected $fillable = [
        'satker_id',
        'laki_doktor',
        'perempuan_doktor',
        'laki_master',
        'perempuan_master',
        'laki_sarjana',
        'perempuan_sarjana',
        'laki_sarjana_muda',
        'perempuan_sarjana_muda',
        'laki_slta',
        'perempuan_slta',
        'laki_sltp',
        'perempuan_sltp',
        'laki_sd',
        'perempuan_sd',
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
