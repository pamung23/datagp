<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peralatan_tangan2 extends Model
{
    use HasFactory;
    protected $table  = 'peralatan_tangan2s';

    protected $fillable = [
        'satker_id',
        'baik1',
        'rusak1',
        'baik2',
        'rusak2',
        'baik3',
        'rusak3',
        'baik4',
        'rusak4',
        'baik5',
        'rusak5',
        'baik6',
        'rusak6',
        'baik7',
        'rusak7',
        'baik8',
        'rusak8',
        'baik9',
        'rusak9',
        'baik10',
        'rusak10',
        'baik11',
        'rusak11',
        'baik12',
        'rusak12',
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
