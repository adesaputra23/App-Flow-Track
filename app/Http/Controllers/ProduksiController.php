<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\PesananDetail;
use App\Models\Produksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
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
                'url' => '/produksi',
                'nama' => 'Proceess Linting'
            ]
        ];
    }

    public function index()
    {
        $list_data = Produksi::with('bahan_baku', 'detail_bahan_baku')->with(['detail_pesanan' => function ($query) {
            return $query->with('pesanan');
        }])->get();
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'list_data' => $list_data,
        ];
        return view('produksi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumdData[] = [
            'url' => '/produksi/tambah',
            'nama' => 'Tambah Data Produksi'
        ];

        $random_kode = 'LNT-' . rand(100000, 999999);
        $produksi_ids = Produksi::pluck('id_detail_pesanan')->toArray();
        $detail_pesanan_list = PesananDetail::when(!empty($produksi_ids), function ($query) use ($produksi_ids) {
            return $query->whereNotIn('id', $produksi_ids);
        })->with('pesanan')->get();
        $bahan_list = BahanBaku::get();
        $karyawan_list = \App\Models\Karyawan::where('no_meja', '!=', null)->get();
   
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'random_kode' => $random_kode,
            'detail_pesanan_list' => $detail_pesanan_list,
            'bahan_list' => $bahan_list,
            'karyawan_list' => $karyawan_list
        ];
        return view('produksi.tambah-data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'kode' => 'required|string|max:255',
                'id_detail_pesanan' => 'required|integer',
                'jumlah_gagal_produksi' => 'required|integer',
                'tanggal' => 'required|date',
                'jam_produksi' => 'required',
                'status_produksi' => 'required|string|max:255',
            ]);

            $produksi = new Produksi();
            if (isset($request->id)) {
                $produksi = Produksi::where('id', $request->id)->first();
            }
            $produksi->kode = $request->kode;
            $produksi->id_detail_pesanan = $request->id_detail_pesanan;
            $produksi->jumlah_batang_gagal_produksi = $request->jumlah_gagal_produksi;
            $produksi->tanggal = $request->tanggal;
            $produksi->jam_produksi = $request->jam_produksi;
            $produksi->status_produksi = $request->status_produksi;
            $produksi->p_jawab = $request->id_petugas;
            $produksi->save();

            if ($request->has('id_bahan') && is_array($request->id_bahan)) {

                $cekData = DB::table('detail_produksi_bahan_baku')
                    ->where('id_produksi', $produksi->id)
                    ->get();

                    if ($cekData) {
                        DB::table('detail_produksi_bahan_baku')
                            ->where('id_produksi', $produksi->id)
                            ->delete();
                    }

                foreach ($request->id_bahan as $key => $id_bahan) {
                    DB::table('detail_produksi_bahan_baku')->insert([
                        'id_produksi' => $produksi->id,
                        'id_bahan_baku' => $id_bahan,
                        'jumlah_bahan' => isset($request->jumlah_bahan[$id_bahan]) ? $request->jumlah_bahan[$id_bahan] : 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $bahan_baku = BahanBaku::where('id', $id_bahan)->first();
                    if (isset($request->id) && isset($cekData[$key])) {
                        if ($cekData[$key]->jumlah_bahan == $request->jumlah_bahan[$id_bahan]) {
                            // stok tidak berubah
                        } else {
                            $bahan_baku->stok = $bahan_baku->stok + $cekData[$key]->jumlah_bahan - $request->jumlah_bahan[$id_bahan];
                        }
                    } else {
                        $bahan_baku->stok = $bahan_baku->stok - $request->jumlah_bahan[$id_bahan];
                    }
         

                    if ($bahan_baku->stok < 0) {
                        return redirect()->route('produksi.index')->with('error', 'Data Stok Bahan Baku '. $bahan_baku->nama_bahan. ' Tidak Tersedia.');
                    }

                    $bahan_baku->save(); 
                }
            }

            DB::commit();

            return redirect()->route('produksi.index')->with('success', 'Data produksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data produksi: ' . $e->getMessage() . '-' . $e->getLine());
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
        $this->breadcrumdData[] = [
            'url' => '/produksi/tambah',
            'nama' => 'Tambah Data Produksi'
        ];
        $this->breadcrumdData[] = [
            'url' => '/produksi/detail' . $id,
            'nama' => 'Detail Item Produksi'
        ];

        $produksi = Produksi::with('bahan_baku')->with(['detail_pesanan' => function ($query) {
            return $query->with('pesanan');
        }])->where('id', $id)->first();

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'produksi' => $produksi,
        ];

        return view('produksi.detail', $data);
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
            'url' => '/produksi/tambah',
            'nama' => 'Tambah Data Produksi'
        ];

        $data_produksi = Produksi::with('detail_bahan_baku')->where('id', $id)->first();
        $random_kode = 'PRD-' . rand(100000, 999999);
        $produksi_ids = Produksi::where('id', $id)->pluck('id_detail_pesanan')->toArray();
        $detail_pesanan_list = PesananDetail::when(!empty($produksi_ids), function ($query) use ($produksi_ids) {
            return $query->whereIn('id', $produksi_ids);
        })->with('pesanan')->get();
        $bahan_list = BahanBaku::get();
        $karyawan_list = \App\Models\Karyawan::where('no_meja', '!=', null)->get();
        // INSERT_YOUR_CODE
        $detail_bahan_baku = \App\Models\DetailProduksiBahanBaku::where('id_produksi', $id)->pluck('id_bahan_baku')->toArray();

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'random_kode' => $random_kode,
            'detail_pesanan_list' => $detail_pesanan_list,
            'bahan_list' => $bahan_list,
            'data_produksi' => $data_produksi,
            'karyawan_list' => $karyawan_list,
            'detail_bahan_baku' => $detail_bahan_baku
        ];
        // dd($data);
        return view('produksi.tambah-data', $data);
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
        DB::beginTransaction();
        try {
            $produksi = Produksi::with('detail_bahan_baku')->find($id);
            if (!$produksi) {
                return response()->json(['error' => 'Data Produksi tidak ditemukan.'], 404);
            }
            foreach ($produksi->detail_bahan_baku as $key => $value) {
                $bahan_baku = BahanBaku::where('id', $value->id_bahan_baku)->first();
                $bahan_baku->stok = $bahan_baku->stok + $value->jumlah_bahan;
                $bahan_baku->save();
                $value->delete();
            }
            $produksi->delete();
       
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Produksi berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menghapus data.',
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
            DB::rollBack();
        }
    }
}
