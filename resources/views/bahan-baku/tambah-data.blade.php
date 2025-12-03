@extends('app')
@section('title', isset(request()->id) ? 'Edit Data Bahan Baku' : 'Tambah Data Bahan Baku')
@section('content')
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow border">
            <h3 class="text-lg font-bold mb-4">{{ isset(request()->id) ? 'Edit Data Bahan Baku' : 'Tambah Data Bahan Baku' }}</h3>

            @if (session('error'))
                <div class="mb-4">
                    <div class="bg-red-500 text-white px-4 py-3 rounded relative">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('bahan.baku.simpan') }}" method="POST">
                @csrf

                @if (isset($data_bahan))
                    <input type="text" name="id" id="id" hidden value="{{ $data_bahan->id }}">
                @endif

                <div class="mb-4">
                    <label for="nama_bahan" class="block text-sm font-medium text-gray-700 mb-1">Nama Bahan</label>
                    <input type="text" id="nama_bahan" name="nama_bahan" class="w-full p-2 border rounded" required
                        value="{{ isset($data_bahan) ? $data_bahan->nama_bahan :  old('nama_bahan') }}">
                </div>
                <div class="mb-4">
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <input type="satuan" id="satuan" name="satuan" class="w-full p-2 border rounded" required
                        value="{{ isset($data_bahan) ? $data_bahan->satuan :  old('satuan') }}">
                </div>
                <div class="mb-4">
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" id="stok" name="stok" class="w-full p-2 border rounded" required
                        value="{{ isset($data_bahan) ? $data_bahan->stok :  old('stok') }}">
                </div>
                <div class="mb-4">
                    <label for="harga_standar" class="block text-sm font-medium text-gray-700 mb-1">Harga Standar</label>
                    <input type="number" id="harga_standar" name="harga_standar" class="w-full p-2 border rounded" required
                        value="{{ isset($data_bahan) ? $data_bahan->harga_standar : old('harga_standar') }}">
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="w-full p-2 border rounded" rows="3" required>{{ isset($data_bahan) ? $data_bahan->deskripsi : old('deskripsi') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Status</option>
                        <option value="aktif"
                            @if ((isset($data_bahan) ? ($data_bahan->aktif == 1) : old('status')) == 'aktif') selected @endif
                        >Aktif</option>
                        <option value="non_aktif"
                            @if ((isset($data_bahan) ? ($data_bahan->aktif == 2) : old('status')) == 'non_aktif') selected @endif
                        >Non Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 mx-2 rounded text-white font-semibold"
                        style="background-color: #3f4d67;">
                        Simpan
                    </button>
                    <a href="{{ route('bahan.baku.index') }}"
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
