@extends('app')
@section('title', 'Data Detail Produksi')
@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Detail Prouksi</h3>
            <a href="{{ route('produksi.edit', $produksi->id) }}" class="px-4 py-2 rounded text-white transition"
                style="background-color: #3f4d67;">
                Edit Produksi
            </a>
        </div>

        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow border">
            <h4 class="text-lg font-bold mb-4">Detail Data Produksi</h4>
            <div class="mb-6">
                <table class="table-auto w-full text-sm text-left">
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Kode Produksi</td>
                            <td class="py-2">
                                : {{ $produksi->kode ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Nama Pemesan</td>
                            <td class="py-2">
                                : {{ $produksi->detail_pesanan->pesanan->nama ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Instansi</td>
                            <td class="py-2">
                                : {{ $produksi->detail_pesanan->pesanan->instansi ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">No Hp Pemesan</td>
                            <td class="py-2">
                                : {{ $produksi->detail_pesanan->pesanan->no_hp ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Jenis Pensanan</td>
                            <td class="py-2">
                                : {{ $produksi->detail_pesanan->jenis ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Jumlah Pesanan</td>
                            <td class="py-2">
                                : {{ $produksi->detail_pesanan->jumlah ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Jam Pesanan</td>
                            <td class="py-2">
                                : {{ $produksi->detail_pesanan->pesanan->jam ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Tanggal Pesanan</td>
                            <td class="py-2">
                                : {{ isset($produksi->detail_pesanan) ? \Carbon\Carbon::parse($produksi->detail_pesanan->pesanan->created_at)->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Bahan Baku</td>
                            <td class="py-2">
                                : {{ $produksi->bahan_baku->nama_bahan ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Satuan Bahan Baku</td>
                            <td class="py-2">
                                : {{ $produksi->bahan_baku->satuan ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Jumlah Bahan Baku Produksi</td>
                            <td class="py-2">
                                : {{ $produksi->jumlah_bahan ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Jumlah Batang Gagal Produksi</td>
                            <td class="py-2">
                                : {{ $produksi->jumlah_batang_gagal_produksi ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Jam Produksi</td>
                            <td class="py-2">
                                : {{ $produksi->jam_produksi ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Tanggal Produksi</td>
                            <td class="py-2">
                                : {{ isset($produksi->tanggal) ? \Carbon\Carbon::parse($produksi->tanggal)->format('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 pr-4 font-semibold text-gray-700">Status</td>
                            <td class="py-2">: {{ $produksi->status_produksi }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
