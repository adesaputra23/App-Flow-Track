<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('karyawan')->group(function () {
        Route::get('/', [App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/tambah', [App\Http\Controllers\KaryawanController::class, 'create'])->name('karyawan.tambah');
        Route::post('/simpan', [App\Http\Controllers\KaryawanController::class, 'store'])->name('karyawan.simpan');
        Route::get('/edit/{id}', [App\Http\Controllers\KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::delete('/hapus{id}', [App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.hapus');
    });

    Route::prefix('bahan-baku')->group(function () {
        Route::get('/', [App\Http\Controllers\BahanBakuController::class, 'index'])->name('bahan.baku.index');
        Route::get('/tambah', [App\Http\Controllers\BahanBakuController::class, 'create'])->name('bahan.baku.tambah');
        Route::post('/simpan', [App\Http\Controllers\BahanBakuController::class, 'store'])->name('bahan.baku.simpan');
        Route::get('/edit/{id}', [App\Http\Controllers\BahanBakuController::class, 'edit'])->name('bahan.baku.edit');
        Route::delete('/hapus{id}', [App\Http\Controllers\BahanBakuController::class, 'destroy'])->name('bahan.baku.hapus');
    });

    Route::prefix('set-role')->group(function () {
        Route::get('/set-role', [AuthenticatedSessionController::class, 'setRole'])->name('set-role.index');
        Route::get('/add-role', [AuthenticatedSessionController::class, 'addRole'])->name('set-role.add');
        Route::get('/edit-role/{id}', [AuthenticatedSessionController::class, 'editRole'])->name('set-role.edit');
        Route::post('/save-role', [AuthenticatedSessionController::class, 'saveRole'])->name('set-role.save');
        Route::delete('/hapus/{id}', [AuthenticatedSessionController::class, 'destroyRole'])->name('set.role.hapus');
    });

    Route::prefix('pesanan')->group(function () {
        Route::get('/', [App\Http\Controllers\PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/tambah', [App\Http\Controllers\PesananController::class, 'create'])->name('pesanan.tambah');
        Route::post('/simpan', [App\Http\Controllers\PesananController::class, 'store'])->name('pesanan.simpan');
        Route::get('/edit/{id}', [App\Http\Controllers\PesananController::class, 'edit'])->name('pesanan.edit');
        Route::delete('/hapus/{id}', [App\Http\Controllers\PesananController::class, 'destroy'])->name('pesanan.hapus');
        Route::get('/detail/{id}', [App\Http\Controllers\PesananController::class, 'show'])->name('pesanan.detail');
        Route::get('/tambah/item/{id}', [App\Http\Controllers\PesananController::class, 'addItem'])->name('pesanan.add.item');
        Route::post('/simpan/item/{id}', [App\Http\Controllers\PesananController::class, 'simpanItem'])->name('pesanan.simpan.item');
    });

    Route::prefix('produksi')->name('produksi.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProduksiController::class, 'index'])->name('index');
        Route::get('/tambah', [App\Http\Controllers\ProduksiController::class, 'create'])->name('tambah');
        Route::post('/simpan', [App\Http\Controllers\ProduksiController::class, 'store'])->name('simpan');
        Route::get('/edit/{id}', [App\Http\Controllers\ProduksiController::class, 'edit'])->name('edit');
        Route::delete('/hapus/{id}', [App\Http\Controllers\ProduksiController::class, 'destroy'])->name('hapus');
        Route::get('/detail/{id}', [App\Http\Controllers\ProduksiController::class, 'show'])->name('detail');
    });

    // INSERT_YOUR_CODE
    Route::prefix('hasil-produksi')->name('hasil-produksi.')->group(function () {
        Route::get('/', [App\Http\Controllers\HasilProduksiController::class, 'index'])->name('index');
        Route::get('/cetak', [App\Http\Controllers\HasilProduksiController::class, 'cetakPdf'])->name('cetak');
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__ . '/auth.php';
