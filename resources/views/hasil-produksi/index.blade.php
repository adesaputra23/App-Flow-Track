@extends('app')
@section('title', 'Data Produksi')
@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Produksi</h3>
            <a href="{{ route('hasil-produksi.cetak', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                class="px-4 py-2 rounded text-white transition" style="background-color: #3f4d67;">
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
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                    required class="border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            QR Code
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Gambar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Petugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($list_data as $i => $data)
                        @php
                            $dataScann = "Pesanan: {$data->produksi->detail_pesanan->pesanan->nama}, Instansi: {$data->produksi->detail_pesanan->pesanan->instansi}, Jenis Pesanan: {$data->produksi->detail_pesanan->jenis}, Jumlah: {$data->produksi->detail_pesanan->jumlah}";
                        @endphp
                        <tr>
                            <td class="px-6 py-4 border border-gray-300 text-center">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 border border-gray-300 text-center">
                                <button class="btn-download-qr"
                                    data-qr-url="https://api.qrserver.com/v1/create-qr-code/?size=380x380&data={{ $dataScann }}"
                                    data-qr-filename="qr_packing_{{ $data->produksi->detail_pesanan->jenis }}_{{ $data->id }}.png">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=User-ID:{{ $data->id }}"
                                        alt="QR Code ID {{ $data->id }}" style="width:48px; height:48px;">
                                </button>
                            </td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->produksi->detail_pesanan->jenis }}</td>
                            <td class="px-6 py-4 border border-gray-300 text-center">
                                @if (!empty($data->produksi->detail_pesanan->image))
                                    <img src="{{ asset('storage/pesanan_gambar/' . $data->produksi->detail_pesanan->image) }}"
                                        alt="Gambar" class="h-10 w-10 object-cover mx-auto rounded">
                                @else
                                    <span class="text-gray-400 italic">- Tidak ada gambar -</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 border border-gray-300">{{ $data->jumlah_packing }}
                                {{ $data->produksi->detail_pesanan->satuan ?? '' }}</td>

                            <td class="px-6 py-4 border border-gray-300 text-center">
                                {{ $data->created_at->format('H:i:s') }}</td>
                            <td class="px-6 py-4 border border-gray-300 text-center">
                                {{ $data->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->karyawan->nama_lengkap ?? '-' }}</td>
                            <td class="px-6 py-4 border border-gray-300">{{ $data->status }}</td>
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

            // INSERT_YOUR_CODE
            $('.btn-download-qr').on('click', function(e) {
                // Otomatis download file tanpa interaksi manual
                const qrUrl = $(this).data('qr-url');
                const qrName = $(this).data('qr-filename');
                const qrUser = $(this).data('qr-user') || '';

                // Buat tampilan menarik: preview dengan nama di bawah dan kotak border menggunakan SweetAlert2
                Swal.fire({
                    html: `
                    <div style="display: flex; flex-direction: column; align-items: center; border: 2px solid #3b82f6; border-radius: 12px; padding: 28px 24px 18px 24px; background: #fff; box-shadow: 0 4px 16px rgba(30,64,175,.07);">
                        <img src="${qrUrl}" alt="QR Code" style="width: 192px; height: 192px; border: 1.5px dashed #3b82f6; border-radius: 10px; background: #f9fafb; margin-bottom: 20px;">
                        <div style="font-weight: 600; margin-bottom: 5px; font-size: 1.18em;">${qrName.replace('.png','')}</div>
                        ${qrUser
                            ? `<span style="color: #64748b; font-size:13px; font-style:italic;">${qrUser}</span>`
                            : ''
                        }
                        <button id="btn-confirm-download-qr" style="
                            margin-top:16px;
                            background: #3b82f6; color: #fff; border: none;
                            border-radius: 8px; padding: 8px 20px; cursor: pointer; font-size: 15px; font-weight: 500;"
                        >Download QR</button>
                    </div>
                `,
                    showConfirmButton: false,
                    showCloseButton: true,
                    width: 330,
                    customClass: {
                        popup: 'p-0'
                    },
                });

                $(document).off('click', '#btn-confirm-download-qr').on('click', '#btn-confirm-download-qr',
                    function() {
                        fetch(qrUrl)
                            .then(res => res.blob())
                            .then(blob => {
                                const url = window.URL.createObjectURL(blob);
                                const dl = document.createElement('a');
                                dl.style.display = 'none';
                                dl.href = url;
                                dl.download = qrName;
                                document.body.appendChild(dl);
                                dl.click();
                                window.URL.revokeObjectURL(url);
                                document.body.removeChild(dl);
                                Swal.close();
                            });
                    });


            });
        });
    </script>
@endsection
