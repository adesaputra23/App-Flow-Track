<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Karyawan;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */

    protected $breadcrumdData;

    public function __construct()
    {
        $this->breadcrumdData = [
            [
                'url' => '/set-role/set-role',
                'nama' => 'Setting Data Role'
            ]
        ];
    }

    public function create()
    {
        // return view('auth.login');
        return view('auth.new_login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->intended(RouteServiceProvider::HOME);
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function setRole()
    {
        $list_data = User::get();
        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'list_data' => $list_data
        ];
        return view('auth.set-role', $data);
    }

    public function addRole()
    {
        $this->breadcrumdData[] = [
            'url' => '/set-role/add-role',
            'nama' => 'Tambah Data User'
        ];

        $karyawans = Karyawan::where('id_user', null)->get();

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'karyawans' => $karyawans
        ];
        return view('auth.form-add-user', $data);
    }

    public function saveRole(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'karyawan_id' => 'required|exists:karyawan,id',
                'role' => 'required|in:admin,manager,kepala_produksi',
                'status' => 'required|in:1,2',
            ]);

            // Pastikan karyawan belum punya user
            $karyawan = Karyawan::find($validated['karyawan_id']);
            if (!$karyawan) {
                return back()->withErrors(['karyawan_id' => 'Karyawan tidak ditemukan.'])->withInput();
            }

            if (!isset($request->id) && $karyawan->id_user) {
                return back()->withErrors(['karyawan_id' => 'Karyawan sudah memiliki user.'])->withInput();
            }

            // Buat akun user baru
            // Email, nama dan password default dari karyawan
            $email = $karyawan->email;
            $name = $karyawan->nama_lengkap ?? $karyawan->nama ?? 'User-' . $karyawan->id;

            // Password default: 'password'
            $user = new User();
            $user->password = bcrypt('password');

            if (isset($request->id)) {
                $user = User::where('id', $request->id)->first();
            }

            $user->name = $name;
            $user->email = $email;
            $user->role = $validated['role'];
            $user->status = $validated['status'];
            $user->save();

            // Set id_user di karyawan
            $karyawan->id_user = $user->id;
            $karyawan->save();

            DB::commit();
            return redirect()->route('set-role.index')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function editRole($id)
    {
        $this->breadcrumdData[] = [
            'url' => '/set-role/edit-role',
            'nama' => 'Edit Data User'
        ];

        $karyawan = [Karyawan::whereHas('user')->where('id_user', $id)->first()];

        $data = [
            'breadcrumd_data' => $this->breadcrumdData,
            'karyawans' => $karyawan
        ];
        return view('auth.form-add-user', $data);
    }

    public function destroyRole($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Data User tidak ditemukan.'], 404);
        }

        try {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}
