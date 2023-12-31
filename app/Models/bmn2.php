<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bmn2 extends Model
{
    use HasFactory;
    protected $table = 'bmn2s';

    protected $fillable = [
        'satker_id',
        'kode',
        'uraian',
        'satuan',
        'kuantitas1',
        'nilai1',
        'kuantitas2',
        'nilai2',
        'kuantitas3',
        'nilai3',
        'kuantitas4',
        'nilai4',
        'keterangan',
    ];
}
