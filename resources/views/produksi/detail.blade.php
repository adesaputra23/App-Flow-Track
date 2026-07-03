@extends('app')
@section('title', 'Data Detail Produksi')
@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Detail Packing</h3>
            <a href="{{ route('produksi.edit', $produksi->id) }}" class="px-4 py-2 rounded text-white transition"
                style="background-color: #3f4d67;">
                Edit Produksi
            </a>
        </div>

        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow border">
            <h4 class="text-lg font-bold mb-4">Detail Data Packing</h4>
            <div class="mb-6">
                <table class="table-auto w-full text-sm text-left">
                    <tbody>
                        <tr>
                            <td rowspan="14" class="align-top pr-6 bg-gradient-to-br from-blue-100 to-indigo-100"
                                style="width:170px;">
                                @if (!empty($produksi->detail_pesanan->image))
                                    <div class="flex flex-col items-center p-4 mx-4">
                                        <img src="{{ asset('storage/pesanan_gambar/' . $produksi->detail_pesanan->image) }}"
                                            alt="Gambar"
                                            class="h-40 w-40 object-cover rounded-xl shadow-lg ring-4 ring-indigo-300 mb-3 hover:scale-105 transition-transform duration-300">
                                        <span class="text-xs text-gray-500 mt-1">Gambar Produk</span>
                                    </div>
                                @else
                                    <div
                                        class="flex flex-col items-center justify-center h-40 w-40 bg-gray-100 rounded-xl shadow-inner border border-dashed border-gray-300">
                                        <span class="text-gray-400 italic text-base">- Tidak ada gambar -</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 pr-4 font-bold text-indigo-700 flex items-center gap-2">
                                <i class="fa fa-barcode text-indigo-500"></i> Kode Packing
                            </td>
                            <td class="py-3 text-base">
                                <span
                                    class="font-mono rounded px-2 py-1 bg-indigo-50 text-indigo-900">{{ $produksi->kode ?? '-' }}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-user text-indigo-500"></i> Nama Pemesan
                            </td>
                            <td class="py-3 text-base">
                                <span class="font-semibold">{{ $produksi->detail_pesanan->pesanan->nama ?? '-' }}</span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-building text-indigo-500"></i> Instansi
                            </td>
                            <td class="py-3">{{ $produksi->detail_pesanan->pesanan->instansi ?? '-' }}</td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-phone text-indigo-500"></i> No Hp Pemesan
                            </td>
                            <td class="py-3">{{ $produksi->detail_pesanan->pesanan->no_hp ?? '-' }}</td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-cubes text-indigo-500"></i> Jenis Pesanan
                            </td>
                            <td class="py-3">{{ $produksi->detail_pesanan->jenis ?? '-' }}</td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-sort-numeric-up text-indigo-500"></i> Jumlah Pesanan
                            </td>
                            <td class="py-3">{{ $produksi->detail_pesanan->jumlah ?? '-' }} {{ $produksi->detail_pesanan->satuan ?? '' }}</td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-clock text-indigo-500"></i> Jam Pesanan
                            </td>
                            <td class="py-3">{{ $produksi->detail_pesanan->pesanan->jam ?? '-' }}</td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-calendar-alt text-indigo-500"></i> Tanggal Pesanan
                            </td>
                            <td class="py-3">
                                {{ isset($produksi->detail_pesanan) ? \Carbon\Carbon::parse($produksi->detail_pesanan->pesanan->created_at)->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700 flex items-center">
                                <i class="fa fa-times-circle text-indigo-500"></i> Jumlah Batang Gagal Produksi
                            </td>
                            <td class="py-3">
                                <span class="inline-block rounded-full bg-red-50 text-red-700 px-3 py-1 font-semibold">
                                    {{ $produksi->jumlah_batang_gagal_produksi ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-stopwatch text-indigo-500"></i> Jam Produksi
                            </td>
                            <td class="py-3">{{ $produksi->jam_produksi ?? '-' }}</td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-calendar-day text-indigo-500"></i> Tanggal Produksi
                            </td>
                            <td class="py-3">
                                {{ isset($produksi->tanggal) ? \Carbon\Carbon::parse($produksi->tanggal)->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-indigo-50">
                            <td class="py-3 pr-4 font-bold text-gray-700">
                                <i class="fa fa-info-circle text-indigo-500"></i> Status
                            </td>
                            <td class="py-3">
                                <span
                                    class="inline-block px-3 py-1 rounded-full 
                                    @if ($produksi->status_produksi == 'Selesai') bg-green-500 
                                    @elseif($produksi->status_produksi == 'Proses') bg-yellow-500
                                    @else bg-gray-500 @endif">
                                    {{ $produksi->status_produksi }}
                                </span>
                            </td>
                        </tr>
                    </tbody>


                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
