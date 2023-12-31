<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenebanganLiar extends Model
{
    use HasFactory;
    protected $fillable = ['resort', 'bulan', 'latitude', 'longitude', 'nama'];
}
