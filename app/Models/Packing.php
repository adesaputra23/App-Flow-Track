<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;
    protected $table = 'packing';
    public $incrementing = true;
    public $timestamps = true;

    public function produksi()
    {
        return $this->belongsTo(\App\Models\Produksi::class, 'id_produksi', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(\App\Models\Karyawan::class, 'p_jawab', 'id');
    }
}
