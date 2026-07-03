@extends('app')
@section('title', 'Data Produksi')
@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Linting</h3>
            <a href="{{ route('produksi.tambah') }}" class="px-4 py-2 rounded text-white transition"
                style="background-color: #3f4d67;">
                Tambah Linting
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
                <div class="bg-red-500 text-white px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <div class="w-full overflow-x-auto">
                <table id="table" class="min-w-full divide-y divide-gray-200 bg-white shadow rounded border border-gray-400">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Kode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Instansi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Jenis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Gambar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Jumlah
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase border border-gray-300 text-center">
                                Bahan Baku
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Jam
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Petugas
                            </th> 
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($list_data as $i => $data)
                            <tr>
                                <td class="px-6 py-4 border border-gray-300 text-center">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 border border-gray-300">{{ $data->kode }}</td>
                                <td class="px-6 py-4 border border-gray-300">{{ ($data->detail_pesanan->pesanan->instansi) }}</td>
                                <td class="px-6 py-4 border border-gray-300">{{ ($data->detail_pesanan->jenis) }}</td>
                                <td class="px-6 py-4 border border-gray-300 text-center">
                                    @if (!empty($data->detail_pesanan->image))
                                        <img src="{{ asset('storage/pesanan_gambar/' . $data->detail_pesanan->image) }}" alt="Gambar" class="h-10 w-10 object-cover mx-auto rounded">
                                    @else
                                        <span class="text-gray-400 italic">- Tidak ada gambar -</span>
                                    @endif
                                </td>
                        
                                <td class="px-6 py-4 border border-gray-300">
                                    {{ $data->detail_pesanan->jumlah }} {{ $data->detail_pesanan->satuan ?? '' }}
                                </td>
                           
                                <td class="px-6 py-4 border border-gray-300">
                                    <ul class="">
                                        @forelse ($data->detail_bahan_baku as $key => $detail)
                                            <li>{{ $key+1 }}. {{ $detail->bahan_baku->nama_bahan ?? '-' }} - {{ $detail->jumlah_bahan }} {{ $detail->bahan_baku->satuan }}</li>
                                        @empty
                                            <li>-</li>
                                        @endforelse
                                    </ul>
                                </td>
                                <td class="px-6 py-4 border border-gray-300 text-center">{{ $data->jam_produksi }}</td>
                                <td class="px-6 py-4 border border-gray-300 text-center">{{ $data->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 border border-gray-300">{{ $data->karyawan->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-4 border border-gray-300">{{ $data->status_produksi }}</td>
                                <td class="px-6 py-4 border border-gray-300 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('produksi.edit', $data->id) }}"
                                            class="inline-flex items-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                                            Edit
                                        </a>
                                        <button name="btn-hapus" data-id="{{ $data->id }}"
                                            data-nama="{{ $data->kode }}"
                                            class="btn-hapus inline-flex items-center bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-red-400 text-sm">
                                            Hapus
                                        </button>
                                        <a href="{{ route('produksi.detail', $data->id) }}"
                                            class="inline-flex items-center bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm">
                                            Detail
                                        </a>
                                    </div>
                               
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
       
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // Inisialisasi DataTable dengan opsi responsive
            $('#table').DataTable({
                responsive: true
            });
    

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
