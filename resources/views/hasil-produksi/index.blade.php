@extends('app')
@section('title', 'Data Produksi')
@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Produksi</h3>
            <a href="{{ route('hasil-produksi.cetak', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}" class="px-4 py-2 rounded text-white transition"
                style="background-color: #3f4d67;">
                Cetak PDF
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

        <form action="{{ route('hasil-produksi.index') }}" method="GET" class="mb-4 flex items-end gap-4">
            <div>
                <label for="tanggal_awal" class="block text-sm text-gray-700 mb-1">Tanggal Awal</label>
                <input type="date" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}" required
                    class="border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="tanggal_akhir" class="block text-sm text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" required
                    class="border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-500 rounded text-white hover:bg-blue-600 transition">
                    Filter
                </button>
                <a href="{{ route('hasil-produksi.index') }}"
                    class="ml-2 px-4 py-2 bg-gray-400 rounded text-white hover:bg-gray-500 transition">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table id="table" class="w-full divide-y divide-gray-200 bg-white shadow rounded border border-gray-400">
                <thead class="bg-gray-100">
                    <tr>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            No
                        </th>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Kode</th>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Instansi</th>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jenis</th>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jumlah</th>
                        <th colspan="2"
                            class="px-6 py-3 text-xs font-medium text-gray-600 uppercase border border-gray-300 text-center">
                            Bahan Baku
                        </th>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jam</th>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Tanggal</th>
                        <th rowspan="2"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Status</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($list_data as $i => $data)
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 text-center">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->kode }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->detail_pesanan->pesanan->instansi }}
                            </td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->detail_pesanan->jenis }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->detail_pesanan->jumlah }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->bahan_baku->nama_bahan }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->jumlah_bahan }}</td>
                            <td class="px-6 py-4 border border-gray-300 text-center">{{ $data->jam_produksi }}</td>
                            <td class="px-6 py-4 border border-gray-300 text-center">
                                {{ $data->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->status_produksi }}</td>
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
                const nama = $(this).data('nama') || 'Nama Instansi';
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
                            url: "{{ url('produksi/hapus/') }}/" +
                                id, // Pastikan URL sesuai dengan route destroy jika sudah diimplementasikan
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data Pesanan berhasil dihapus.',
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
