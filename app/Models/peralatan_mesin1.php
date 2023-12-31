<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peralatan_mesin1 extends Model
{
    use HasFactory;
    protected $table  = 'peralatan_mesin1s';

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
        'baik13',
        'rusak13',
        'baik14',
        'rusak14',
        'baik15',
        'rusak15',
        'lain',
        'keterangan',
    ];
}
