<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peralatan_transportasi1 extends Model
{
    use HasFactory;
    protected $table  = 'peralatan_transportasi1s';

    protected $fillable = [
        'satker_id',
        'daops',
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
        'lain1',
        'baik6',
        'rusak6',
        'baik7',
        'rusak7',
        'baik8',
        'rusak8',
        'lain2',
        'keterangan',
    ];
}
