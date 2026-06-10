<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produksi extends Model
{
    use HasFactory;
    protected $table = 'produksi';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'kode',
        'id_detail_pesanan',
        'id_bahan',
        'jumlah_bahan',
        'jumlah_batang_gagal_produksi',
        'tanggal',
        'jam_produksi',
        'status_produksi',
    ];

    public function detail_pesanan()
    {
        return $this->belongsTo(PesananDetail::class, 'id_detail_pesanan');
    }

    public function bahan_baku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku');
    }

    public function detail_bahan_baku()
    {
        return $this->hasMany(DetailProduksiBahanBaku::class, 'id_produksi', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(\App\Models\Karyawan::class, 'p_jawab', 'id');
    }
}
