@extends('app')
@section('title', 'Data Bahan Produksi')
@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Bahan Produksi</h3>
            <a href="{{ route('bahan.baku.tambah') }}" class="px-4 py-2 rounded text-white transition"
                style="background-color: #3f4d67;">
                Tambah Bahan Produksi
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4">
                <div class="bg-green-500 border border-green-600 text-white px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4">
                <div class="bg-red-600 border border-red-700 text-white px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="table" class="w-full divide-y divide-gray-200 bg-white shadow rounded border border-gray-400">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Nama Bahan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Satuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Harga Standar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($list_data as $i => $bahan_baku)
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 text-center">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $bahan_baku->nama_bahan }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $bahan_baku->satuan }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $bahan_baku->stok }}</td>
                            <td class="px-6 py-4 border border-gray-300 text-center">{{ $bahan_baku->harga_standar }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $bahan_baku->aktif == 1 ? 'aktif' : 'non aktif' }}</td>
                            <td class="px-6 py-4 border border-gray-300 text-center">
                                <a href="{{ route('bahan.baku.edit', $bahan_baku->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-3 transition-colors duration-150">Edit</a>
                                <button id="btn-hapus" name="btn-hapus" data-id="{{ $bahan_baku->id }}"
                                    data-nama="{{ $bahan_baku->nama_bahan }}"
                                    class="btn-hapus bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-150">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#table').DataTable();

            // Ganti id dengan class karena id harus unik!
            $('.btn-hapus').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama') || 'Nama Karyawan';
                Swal.fire({
                    title: 'Hapus Data',
                    text: 'Apakah anda yakin ingin menghapus ' + nama + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('bahan-baku/hapus/') }}" +
                            id, // Pastikan URL sesuai dengan route destroy jika sudah diimplementasikan
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data karyawan berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                                location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
