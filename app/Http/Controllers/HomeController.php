<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Karyawan;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Produksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $breadcrumdData;

    public function __construct()
    {
        $this->breadcrumdData = [
            [
                'url' => '/dashboard',
                'nama' => 'Dashboard'
            ]
        ];
    }

    public function index()
    {
        $count_karyawan = Karyawan::count();
        $count_pesanan = Pesanan::count();
        $count_pesanan_detail = PesananDetail::count();
        $count_bahan_baku = BahanBaku::count();
        $count_produksi = Produksi::count();
        $count_ = Pesanan::count();
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'count_karyawan' => $count_karyawan,
            'count_pesanan' => $count_pesanan,
            'count_bahan_baku' => $count_bahan_baku,
            'count_produksi' => $count_produksi,
            'count_pesanan_detail' => $count_pesanan_detail
        ];
        return view('home.index', $data);
    }
}
