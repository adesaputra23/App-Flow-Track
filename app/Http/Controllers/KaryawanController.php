<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
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
                'url' => '/karyawan',
                'nama' => 'Master Karyawan'
            ]
        ];
    }

    public function index()
    {
        $list_data = Karyawan::get();
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'list_data' => $list_data
        ];
        return view('karyawan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumdData[] = [
            'url' => '/karyawan/tambah',
            'nama' => 'Tambah Data Karyawan'
        ];

        $data = [
            'breadcrumd_data' => $this->breadcrumdData
        ];
        return view('karyawan.tambah_data', $data);
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
            // Validasi data jika diperlukan
            $request->validate([
                'nama' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'no_meja' => 'required|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_hp' => 'required|string|max:20',
                'status_karyawan' => 'required|in:tetaP,kontrak,tetap,kontrak',
            ]);

            // Simpan data karyawan ke database
            // Pastikan Model Karyawan sudah tersedia
            $karyawan = new \App\Models\Karyawan();

            if (isset($request->id)) {
                $karyawan = Karyawan::where('id', $request->id)->first();
            }

            $karyawan->nama_lengkap = $request->nama;
            $karyawan->email = $request->email;
            $karyawan->jabatan = $request->jabatan;
            $karyawan->no_meja = $request->no_meja;
            $karyawan->status = $request->status_karyawan;
            $karyawan->no_hp = $request->no_hp;
            $karyawan->jenis_kelamin = $request->jenis_kelamin;
            $karyawan->save();

            DB::commit();

            return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data karyawan: ' . $e->getMessage());
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
            'url' => '/karyawan/edit/' . $id,
            'nama' => 'Edit Data Karyawan'
        ];

        $data_karyawan = Karyawan::findOrFail($id);

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'data_karyawan' => $data_karyawan
        ];
        return view('karyawan.tambah_data', $data);
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
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['error' => 'Data karyawan tidak ditemukan.'], 404);
        }

        try {
            $karyawan->delete();
            return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}
