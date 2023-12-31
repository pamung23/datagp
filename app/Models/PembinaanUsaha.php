<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembinaanUsaha extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'pembinaan_usahas';
    public function pembinaan()
    {
        return $this->morphTo();
    }
}
