@extends('app')
@section('title', 'Data Detail Pesanan')
@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Detail Pesanan</h3>
            <a href="{{ route('pesanan.add.item', $pesanan->id) }}" class="px-4 py-2 rounded text-white transition"
                style="background-color: #3f4d67;">
                Edit Pesanan
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
            <table class="w-full divide-y divide-gray-200 bg-white shadow rounded border border-gray-400">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase border border-gray-300">
                            Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if (isset($detail_pesanans) && count($detail_pesanans) > 0)
                        @foreach ($detail_pesanans as $i => $detail)
                            <tr>
                                <td class="px-6 py-4 border border-gray-300 text-center">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 border border-gray-300">{{ $detail->jenis }}</td>
                                <td class="px-6 py-4 border border-gray-300 text-center">{{ $detail->jumlah }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="px-6 py-4 border border-gray-300 text-center text-gray-500">Tidak ada
                                detail pesanan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
