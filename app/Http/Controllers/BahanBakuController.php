<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanBakuController extends Controller
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
                 'url' => '/bahan-baku',
                 'nama' => 'Master Bahan Produksi'
             ]
         ];
     }
 

    public function index()
    {
        $list_data = BahanBaku::get();
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'list_data' => $list_data
        ];
        return view('bahan-baku.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumdData[] = [
            'url' => '/bahan-baku/tambah',
            'nama' => 'Tambah Data Bahan Produksi'
        ];

        $data = [
            'breadcrumd_data' => $this->breadcrumdData
        ];
        return view('bahan-baku.tambah-data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // Validasi data jika diperlukan
            $request->validate([
                'nama_bahan' => 'required|string|max:255',
                'satuan' => 'required|string|max:255',
                'stok' => 'required|integer',
                'harga_standar' => 'required|integer',
                'deskripsi' => 'required|string',
                'status' => 'required|string',
            ]);

            // Simpan data karyawan ke database
            // Pastikan Model Karyawan sudah tersedia
            $bahan_baku = new \App\Models\BahanBaku();

            if (isset($request->id)) {
                $bahan_baku = BahanBaku::where('id', $request->id)->first();
            }

            $bahan_baku->nama_bahan = $request->nama_bahan;
            $bahan_baku->satuan = $request->satuan;
            $bahan_baku->stok = (int) str_replace(',', '', $request->stok);
            $bahan_baku->harga_standar = (int) str_replace(',', '', $request->harga_standar);
            $bahan_baku->deskripsi = $request->deskripsi;
            $bahan_baku->aktif = $request->status === 'aktif' ? 1 : 2;
            $bahan_baku->save();

            DB::commit();

            return redirect()->route('bahan.baku.index')->with('success', 'Data Bahan Produksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data Bahan Produksi: ' . $e->getMessage(). '-'. $e->getLine());
        }
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
        $this->breadcrumdData[] = [
            'url' => '/bahan-baku/edit/' . $id,
            'nama' => 'Edit Data Bahan Produksi'
        ];

        $data_bahan = BahanBaku::findOrFail($id);

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'data_bahan' => $data_bahan
        ];
        return view('bahan-baku.tambah-data', $data);
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
        $bahan_baku = BahanBaku::find($id);

        if (!$bahan_baku) {
            return response()->json(['error' => 'Data karyawan tidak ditemukan.'], 404);
        }

        try {
            $bahan_baku->delete();
            return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}
