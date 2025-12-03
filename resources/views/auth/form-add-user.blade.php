@extends('app')
@section('title', 'Tambah User')
@section('content')
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow border">
            <h3 class="text-lg font-bold mb-4">Tambah User</h3>

            @if (session('error'))
                <div class="mb-4">
                    <div class="bg-red-500 text-white px-4 py-3 rounded relative">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('set-role.save') }}" method="POST">
                @csrf

                @if (isset($karyawans[0]->user))
                    <input type="text" name="id" id="id" hidden value="{{ $karyawans[0]->id_user }}">
                @endif

                <div class="mb-4">
                    <label for="karyawan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Karyawan</label>
                    <select id="karyawan_id" name="karyawan_id" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach($karyawans as $k)
                            <option value="{{ $k->id ?? $k->id_user }}" {{isset($k->id_user) ? 'selected' : '' }}  {{ old('karyawan_id') == ($k->id ?? $k->id_user) ? 'selected' : '' }}>
                                {{ $k->nama_lengkap ?? $k->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="role" name="role" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Role</option>
                        <option value="admin" {{isset($karyawans[0]->user) && $karyawans[0]->user->role == 'admin' ? 'selected' : '' }}  {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{isset($karyawans[0]->user) && $karyawans[0]->user->role == 'manager' ? 'selected' : '' }}  {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="kepala_produksi" {{isset($karyawans[0]->user) && $karyawans[0]->user->role == 'kepala_produksi' ? 'selected' : '' }}  {{ old('role') == 'kepala_produksi' ? 'selected' : '' }}>Kepala Produksi</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Status</option>
                        <option value="1" {{isset($karyawans[0]->user) && $karyawans[0]->user->status == 1 ? 'selected' : '' }}  {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="2" {{isset($karyawans[0]->user) && $karyawans[0]->user->status == 2 ? 'selected' : '' }}  {{ old('status') == '2' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 mx-2 rounded text-white font-semibold"
                        style="background-color: #3f4d67;">
                        Simpan
                    </button>
                    <a href="{{ route('set-role.index') }}"
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
