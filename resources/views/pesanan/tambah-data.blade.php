@extends('app')
@section('title', isset(request()->id) ? 'Edit Data Pesanan' : 'Tambah Data Pesanan')
@section('content')
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow border">
            <h3 class="text-lg font-bold mb-4">{{ isset(request()->id) ? 'Edit Data Pesanan' : 'Tambah Data Pesanan' }}</h3>

            @if (session('error'))
                <div class="mb-4">
                    <div class="bg-red-500 border border-red-700 text-white px-4 py-3 rounded relative">
                        <span class="block sm:inline" style="background-color: red; color: white;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('pesanan.simpan') }}" method="POST">
                @csrf

                @if (isset($data_pesanann))
                    <input type="text" name="id" id="id" hidden value="{{ $data_pesanann->id }}">
                @endif

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="nama" name="nama" class="w-full p-2 border rounded" required
                        value="{{ isset($data_pesanann) ? $data_pesanann->nama : old('nama') }}">
                </div>

                <div class="mb-4">
                    <label for="nama_instansi" class="block text-sm font-medium text-gray-700 mb-1">Nama Instansi</label>
                    <input type="text" id="nama_instansi" name="nama_instansi" class="w-full p-2 border rounded" required
                        value="{{ isset($data_pesanann) ? $data_pesanann->instansi : old('nama_instansi') }}">
                </div>

                <div class="mb-4">
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="w-full p-2 border rounded" required
                        value="{{ isset($data_pesanann) ? $data_pesanann->no_hp : old('no_hp') }}">
                </div>

                <div class="mb-4">
                    <label for="jam" class="block text-sm font-medium text-gray-700 mb-1">Jam</label>
                    <input type="time" id="jam" name="jam" class="w-full p-2 border rounded" required
                        value="{{ isset($data_pesanann) ? $data_pesanann->jam : old('jam') }}">
                </div>

                <div class="mb-4">
                    <label for="status_pesanan" class="block text-sm font-medium text-gray-700 mb-1">Status Pesanan</label>
                    <select id="status_pesanan" name="status_pesanan" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Status</option>
                        <option value="1" @if ((isset($data_pesanann) ? $data_pesanann->status : old('status_pesanan')) == '1') selected @endif>Proses</option>
                        <option value="2" @if ((isset($data_pesanann) ? $data_pesanann->status : old('status_pesanan')) == '2') selected @endif>Selesai</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 mx-2 rounded text-white font-semibold"
                        style="background-color: #3f4d67;">
                        Simpan
                    </button>
                    <a href="{{ route('pesanan.index') }}"
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
