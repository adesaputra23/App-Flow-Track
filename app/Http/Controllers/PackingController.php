<?php

namespace App\Http\Controllers;

use App\Models\Packing;
use App\Models\Produksi;
use Illuminate\Http\Request;

class PackingController extends Controller
{
    protected $breadcrumdData;

    public function __construct()
    {
        $this->breadcrumdData = [
            [
                'url' => '/packikng',
                'nama' => 'Process Packing'
            ]
        ];
    }

    public function index()
    {
        $list_data = Packing::with('produksi', 'karyawan')
            ->with('produksi')
            ->get();
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'list_data' => $list_data,
        ];
        return view('packing.index', $data);
    }

    public function create()
    {
        $produksiSelesai = Produksi::where('status_produksi', 'selesai')
            ->with(['detail_pesanan' => function ($query) {
                return $query->with('pesanan');
            }])
            ->get();
        $karyawan_list = \App\Models\Karyawan::where('bagian', 'packing')->get();

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'produksiSelesai' => $produksiSelesai,
            'karyawan_list' => $karyawan_list
        ];
        return view('packing.tambah-data', $data);
    }

    // INSERT_YOUR_CODE
    public function edit($id)
    {
        // Ambil data packing yang akan diedit beserta relasi
        $packing = Packing::with(['produksi.detail_pesanan.pesanan', 'karyawan'])->findOrFail($id);

        // Data produksi yang selesai untuk pilihan dropdown
        $produksiSelesai = Produksi::where('status_produksi', 'selesai')
            ->with(['detail_pesanan' => function ($query) {
                return $query->with('pesanan');
            }])
            ->get();

        // Daftar karyawan pada bagian packing
        $karyawan_list = \App\Models\Karyawan::where('bagian', 'packing')->get();

        // Breadcrumb
        $this->breadcrumdData[] = [
            'url' => route('packing.edit', $id),
            'nama' => 'Edit Packing'
        ];

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'packing'         => $packing,
            'produksiSelesai' => $produksiSelesai,
            'karyawan_list'   => $karyawan_list
        ];

        return view('packing.tambah-data', $data);
    }

    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'id_produksi' => 'required|exists:produksi,id',
            'jumlah' => 'required|integer|min:1',
            'id_karyawan' => 'required|exists:karyawan,id',
            'status' => 'required|in:proses,selesai'
        ]);

        try {

            // Buat data Packing baru
            if ($request->has('id')) {
                $packing = Packing::where('id', $request->id)->first();
            } else {
                $packing = new Packing();
            }
            $packing->id_produksi = $request->id_produksi;
            $packing->jumlah_packing = $request->jumlah;
            $packing->p_jawab = $request->id_karyawan;
            $packing->status = $request->status;

            $packing->save();

            return redirect()->route('packing.index')->with('success', 'Data packing berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data packing: ' . $e->getMessage());
        }
    }

    // INSERT_YOUR_CODE
    public function destroy($id)
    {
        try {
            $packing = Packing::findOrFail($id);
            $packing->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data packing berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data packing: ' . $e->getMessage()
            ], 500);
        }
    }
}
