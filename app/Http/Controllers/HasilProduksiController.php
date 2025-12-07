<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HasilProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $breadcrumdData;

    public function __construct()
    {
        $this->breadcrumdData = [
            [
                'url' => '/hasil-produksi',
                'nama' => 'Hasil Produksi'
            ]
        ];
    }

    public function index(Request $request)
    {

        $list_data = Produksi::with('bahan_baku')->with(['detail_pesanan' => function ($query) {
            return $query->with('pesanan');
        }]);
        
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $list_data = $list_data->whereDate('tanggal', '>=', $request->tanggal_awal)
                                   ->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $list_data = $list_data->get();

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'list_data' => $list_data
        ];

        return view('hasil-produksi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cetakPDF(Request $request)
    {

        $list_data = Produksi::with('bahan_baku')->with(['detail_pesanan' => function ($query) {
            return $query->with('pesanan');
        }]);
        
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $list_data = $list_data->whereDate('tanggal', '>=', $request->tanggal_awal)
                                   ->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $list_data = $list_data->get();

        $data = [
            'judul' => 'Contoh PDF Laravel', 
            'isi' => 'Ini adalah konten PDF.',
            'list_data' => $list_data
        ];

        $pdf = Pdf::loadView('hasil-produksi.pdf', $data);
        return $pdf->stream('hasil_produksi.pdf');
    }
}
