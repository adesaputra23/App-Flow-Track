<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Produksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
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
                'url' => '/pesanan',
                'nama' => 'Pesanan Produksi'
            ]
        ];
    }

    public function index()
    {
        $list_data = Pesanan::get();
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'list_data' => $list_data
        ];
        return view('pesanan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumdData[] = [
            'url' => '/pesanan/tambah',
            'nama' => 'Tambah Data Pesanan'
        ];

        $data = [
            'breadcrumd_data' => $this->breadcrumdData
        ];
        return view('pesanan.tambah-data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'jam' => 'required',
            'status_pesanan' => 'required|in:1,2',
        ]);

        try {
            $pesanan = new Pesanan();

            if (isset($request->id)) {
                $pesanan = Pesanan::where('id', $request->id)->first();
            }

            $pesanan->nama = $request->nama;
            $pesanan->instansi = $request->nama_instansi;
            $pesanan->no_hp = $request->no_hp;
            $pesanan->jam = $request->jam;
            $pesanan->status = $request->status_pesanan;
            $pesanan->save();

            return redirect()->route('pesanan.index')->with('success', 'Data pesanan berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data pesanan: ' . $e->getMessage());
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
            'url' => '/pesanan/tambah',
            'nama' => 'Tambah Data Pesanan'
        ];
        $this->breadcrumdData[] = [
            'url' => '/pesanan/detail' . $id,
            'nama' => 'Detail Item Pesanan'
        ];

        $pesanan = Pesanan::find($id);
        $detail_pesanans = PesananDetail::where('id_pesanan', $id)->get();

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'pesanan' => $pesanan,
            'detail_pesanans' => $detail_pesanans
        ];

        return view('pesanan.detail', $data);

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
            'url' => '/pesanan/tambah',
            'nama' => 'Edit Data Pesanan'
        ];

        $pesanan = Pesanan::find($id);

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'data_pesanann' => $pesanan
        ];
        return view('pesanan.tambah-data', $data);
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
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json(['error' => 'Data Pesanan tidak ditemukan.'], 404);
        }

        try {
            $pesanan->delete();
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }

    public function addItem($id)
    {
        $this->breadcrumdData[] = [
            'url' => '/pesanan/tambah',
            'nama' => 'Tambah Data Pesanan'
        ];
        $this->breadcrumdData[] = [
            'url' => '/pesanan/tambah/item/' . $id,
            'nama' => 'Tambah Item Pesanan'
        ];

        $pesanan = \App\Models\Pesanan::find($id);
        if (!$pesanan) {
            return redirect()->route('pesanan.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        $detail_pesanans = PesananDetail::where('id_pesanan', $id)->get();

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'pesanan' => $pesanan,
            'detail_pesanans' => $detail_pesanans
        ];

        return view('pesanan.tambah-item', $data);
    }

    public function simpanItem(Request $request, $id)
    {
        // INSERT_YOUR_CODE
        DB::beginTransaction();
        try {
            // INSERT_YOUR_CODE

            // Validasi: semua inputan wajib diisi
            $request->validate([
                'jenis'   => 'required|array',
                'jenis.*' => 'required|string|max:255',
                'jumlah'   => 'required|array',
                'jumlah.*' => 'required|integer|min:1',
            ]);

            // Ambil model pesanan
            $pesanan = \App\Models\Pesanan::find($id);
            if (!$pesanan) {
                return redirect()->route('pesanan.index')->with('error', 'Pesanan tidak ditemukan.');
            }

            // Pastikan count item sesuai antara jenis dan jumlah
            $jenisArr = $request->input('jenis', []);
            $jumlahArr = $request->input('jumlah', []);
            $lenJenis = count($jenisArr);
            $lenJumlah = count($jumlahArr);

            if ($lenJenis !== $lenJumlah) {
                return redirect()->back()->with('error', 'Jumlah dan jenis item tidak sesuai.');
            }

            PesananDetail::where('id_pesanan', $id)->whereNotIn('id', $request->id_detail)->delete();

            for ($i = 0; $i < $lenJenis; $i++) {
                if ($request->has('id_detail') && isset($request->id_detail[$i]) && !empty($request->id_detail[$i])) {
                    \App\Models\PesananDetail::where('id', $request->id_detail[$i])
                        ->update([
                            'jenis' => $jenisArr[$i],
                            'jumlah' => $jumlahArr[$i],
                        ]);
                } else {
                    \App\Models\PesananDetail::create([
                        'id_pesanan' => $pesanan->id,
                        'jenis'      => $jenisArr[$i],
                        'jumlah'     => $jumlahArr[$i],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pesanan.detail', $pesanan->id)->with('success', 'Item berhasil ditambahkan!');
        } catch (\Throwable $th) {
            // INSERT_YOUR_CODE
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan item: ' . $th->getMessage());
        }
    }
}
