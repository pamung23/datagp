<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fungsional2 extends Model
{
    use HasFactory;
    protected $table = 'fungsional2s';

    protected $fillable = [
        'satker_id',
        'calon_terampil_peh', 'terampil_peh', 'calon_ahli_peh', 'ahli_peh', 'jumlah_peh',
        'calon_terampil_polhut', 'terampil_polhut', 'calon_ahli_polhut', 'ahli_polhut', 'jumlah_polhut',
        'calon_terampil_penyuluh', 'terampil_penyuluh', 'calon_ahli_penyuluh', 'ahli_penyuluh', 'jumlah_penyuluh',
        'calon_terampil_pranata', 'terampil_pranata', 'calon_ahli_pranata', 'ahli_pranata', 'jumlah_pranata',
        'calon_terampil_statis', 'terampil_statis', 'calon_ahli_statis', 'ahli_statis', 'jumlah_statis',
        'calon_terampil_analisis', 'terampil_analisis', 'calon_ahli_analisis', 'ahli_analisis', 'jumlah_analisis',
        'calon_terampil_arsiparis', 'terampil_arsiparis', 'calon_ahli_arsiparis', 'ahli_arsiparis', 'jumlah_arsiparis',
        'calon_terampil_perencana', 'terampil_perencana', 'calon_ahli_perencana', 'ahli_perencana', 'jumlah_perencana',
        'calon_terampil_pengadaan', 'terampil_pengadaan', 'calon_ahli_pengadaan', 'ahli_pengadaan', 'jumlah_pengadaan',
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
