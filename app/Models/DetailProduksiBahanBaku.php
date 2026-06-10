<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduksiBahanBaku extends Model
{
    use HasFactory;
    protected $table = 'detail_produksi_bahan_baku';
    public $incrementing = true;
    public $timestamps = true;

    public function bahan_baku()
    {
        return $this->hasOne(BahanBaku::class, 'id', 'id_bahan_baku');
    }
}
