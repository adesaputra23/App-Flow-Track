@extends('app')
@section('title', isset(request()->id) ? 'Edit Data Karyawan' : 'Tambah Data Karyawan')
@section('content')
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow border">
            <h3 class="text-lg font-bold mb-4">{{ isset(request()->id) ? 'Edit Data Karyawan' : 'Tambah Data Karyawan' }}</h3>
            <form action="{{ route('karyawan.simpan') }}" method="POST">
                @csrf

                @if (isset($data_karyawan))
                    <input type="text" name="id" id="id" hidden value="{{ $data_karyawan->id }}">
                @endif

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="nama" name="nama" class="w-full p-2 border rounded" required
                        value="{{ isset($data_karyawan) ? $data_karyawan->nama_lengkap :  old('nama') }}">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded" required
                        value="{{ isset($data_karyawan) ? $data_karyawan->email :  old('email') }}">
                </div>
                <div class="mb-4">
                    <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" class="w-full p-2 border rounded" required
                        value="{{ isset($data_karyawan) ? $data_karyawan->jabatan :  old('jabatan') }}">
                </div>
                <div class="mb-4">
                    <label for="no_meja" class="block text-sm font-medium text-gray-700 mb-1">No Meja</label>
                    <input type="number" id="no_meja" name="no_meja" class="w-full p-2 border rounded" required
                        value="{{ isset($data_karyawan) ? $data_karyawan->no_meja : old('no_meja') }}">
                </div>
                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki"
                            @if (
                                (isset($data_karyawan) ? $data_karyawan->jenis_kelamin : old('jenis_kelamin')) == 'Laki-laki'
                            ) selected @endif
                        >Laki-laki</option>
                        <option value="Perempuan"
                            @if (
                                (isset($data_karyawan) ? $data_karyawan->jenis_kelamin : old('jenis_kelamin')) == 'Perempuan'
                            ) selected @endif
                        >Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="w-full p-2 border rounded" required
                        value="{{ isset($data_karyawan) ? $data_karyawan->no_hp :  old('no_hp') }}">
                </div>
                <div class="mb-4">
                    <label for="status_karyawan" class="block text-sm font-medium text-gray-700 mb-1">Status
                        Karyawan</label>
                    <select id="status_karyawan" name="status_karyawan" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Status</option>
                        <option value="tetap"
                            @if ((isset($data_karyawan) ? $data_karyawan->status : old('status_karyawan')) == 'tetap') selected @endif
                        >Tetap</option>
                        <option value="kontrak"
                            @if ((isset($data_karyawan) ? $data_karyawan->status : old('status_karyawan')) == 'kontrak') selected @endif
                        >Kontrak</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 mx-2 rounded text-white font-semibold"
                        style="background-color: #3f4d67;">
                        Simpan
                    </button>
                    <a href="{{ route('karyawan.index') }}"
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
