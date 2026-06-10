@extends('app')
@section('title', isset(request()->id) ? 'Edit Data Produksi' : 'Tambah Data Produksi')
@section('content')
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow border">
            <h3 class="text-lg font-bold mb-4">{{ isset(request()->id) ? 'Edit Data Packing' : 'Tambah Data Packing' }}</h3>

            @if (session('error'))
                <div class="mb-4">
                    <div class="bg-red-500 border border-red-700 text-white px-4 py-3 rounded relative">
                        <span class="block sm:inline" style="background-color: red; color: white;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('packing.simpan') }}" method="POST">
                @csrf

                @if (isset($packing))
                    <input type="hidden" name="id" value="{{ $packing->id }}">
                @endif        

                <div class="mb-4">
                    <label for="id_produksi" class="block mb-2 font-semibold">Pilih Produksi Selesai</label>
                    <select name="id_produksi" id="id_produksi" class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        <option value="">-- Pilih Produksi --</option>
                        @foreach ($produksiSelesai as $produksi)
                            <option value="{{ $produksi->id }}"
                                {{ (old('id_produksi') == $produksi->id || (isset($packing) && $packing->id_produksi == $produksi->id)) ? 'selected' : '' }}>
                                {{ $produksi->kode }} - {{ $produksi->detail_pesanan->jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="jumlah" class="block mb-2 font-semibold">Jumlah Packing</label>
                    <input 
                        type="number" 
                        name="jumlah" 
                        id="jumlah" 
                        class="w-full px-3 py-2 border border-gray-300 rounded" 
                        min="1"
                        value="{{ old('jumlah', isset($packing) ? $packing->jumlah_packing : '') }}"
                        required
                    >
               
                </div>

                <div class="mb-4">
                    <label for="id_karyawan" class="block mb-2 font-semibold">Pilih Petugas Packing</label>
                    <select name="id_karyawan" id="id_karyawan" class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach ($karyawan_list as $karyawan)
                            <option value="{{ $karyawan->id }}"
                                {{ (old('id_karyawan') == $karyawan->id || (isset($packing) && $packing->p_jawab == $karyawan->id)) ? 'selected' : '' }}>
                                {{ $karyawan->nama_lengkap }}
                            </option>
                       
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="status" class="block mb-2 font-semibold">Status Packing</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="proses" {{ (old('status') == 'proses' || (isset($packing) && $packing->status == 'proses')) ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ (old('status') == 'selesai' || (isset($packing) && $packing->status == 'selesai')) ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
           
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 mx-2 rounded text-white font-semibold"
                        style="background-color: #3f4d67;">
                        Simpan
                    </button>
                    <a href="{{ route('packing.index') }}"
                        class="px-4 py-2 rounded text-white border border-red-600 mr-2 hover:bg-red-600 hover:text-white transition"
                        style="background-color: #dc2626;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
