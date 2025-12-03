@extends('app')
@section('title', isset(request()->id) ? 'Edit Data Produksi' : 'Tambah Data Produksi')
@section('content')
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow border">
            <h3 class="text-lg font-bold mb-4">{{ isset(request()->id) ? 'Edit Data Produksi' : 'Tambah Data Produksi' }}</h3>

            @if (session('error'))
                <div class="mb-4">
                    <div class="bg-red-500 border border-red-700 text-white px-4 py-3 rounded relative">
                        <span class="block sm:inline" style="background-color: red; color: white;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('produksi.simpan') }}" method="POST">
                @csrf

                @if (isset($data_produksi))
                    <input type="text" name="id" id="id" hidden value="{{ $data_produksi->id }}">
                @endif

                <div class="mb-4">
                    <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
                    <input type="text" id="kode" name="kode" class="w-full p-2 border rounded" required readonly
                        value="{{ isset($data_produksi) ? $data_produksi->kode : old('kode', $random_kode) }}">
                </div>

                <div class="mb-4">
                    <label for="id_detail_pesanan" class="block text-sm font-medium text-gray-700 mb-1">Item Pesanan</label>
                    <select id="id_detail_pesanan" name="id_detail_pesanan" class="w-full p-2 border rounded" required>
                        @if (!isset($data_produksi))
                         <option value="">Pilih Item Pesanan</option>
                        @endif
                        @if(isset($detail_pesanan_list) && count($detail_pesanan_list) > 0)
                            @foreach($detail_pesanan_list as $item)
                                <option value="{{ $item->id }}"
                                    @if( (isset($data_produksi) && $data_produksi->id_detail_pesanan == $item->id) || old('id_detail_pesanan') == $item->id )
                                        selected
                                    @endif
                                >
                                    {{ $item->id }} - {{ $item->pesanan->instansi ?? '' }} - {{ $item->jenis ?? '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-4">
                    <label for="id_bahan" class="block text-sm font-medium text-gray-700 mb-1">Bahan Produksi</label>
                    <select id="id_bahan" name="id_bahan" class="w-full p-2 border rounded" required>
                        @if (!isset($data_produksi))
                            <option value="">Pilih Bahan Produksi</option>
                        @endif
                        @if(isset($bahan_list) && count($bahan_list) > 0)
                            @foreach($bahan_list as $bahan)
                                <option value="{{ $bahan->id }}"
                                    @if( (isset($data_produksi) && $data_produksi->id_bahan_baku == $bahan->id) || old('id_bahan') == $bahan->id )
                                        selected
                                    @endif
                                >
                                    {{ $bahan->nama_bahan ?? 'Bahan ' . $bahan->id }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-4">
                    <label for="jumlah_bahan" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bahan</label>
                    <input type="number" min="1" id="jumlah_bahan" name="jumlah_bahan" class="w-full p-2 border rounded" required
                        value="{{ isset($data_produksi) ? $data_produksi->jumlah_bahan : old('jumlah_bahan') }}">
                </div>

                <div class="mb-4">
                    <label for="jumlah_gagal_produksi" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Perbatang Gagal Produksi</label>
                    <input type="number" min="0" id="jumlah_gagal_produksi" name="jumlah_gagal_produksi" class="w-full p-2 border rounded" required
                        value="{{ isset($data_produksi) ? $data_produksi->jumlah_batang_gagal_produksi : old('jumlah_gagal_produksi') }}">
                </div>

                <div class="mb-4">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="w-full p-2 border rounded" required readonly
                        value="{{ isset($data_produksi) ? $data_produksi->tanggal : old('tanggal', date('Y-m-d')) }}">
                </div>

                <div class="mb-4">
                    <label for="jam_produksi" class="block text-sm font-medium text-gray-700 mb-1">Jam Produksi</label>
                    <input type="time" id="jam_produksi" name="jam_produksi" class="w-full p-2 border rounded" readonly 
                        value="{{ date('H:i') }}">
                </div>

                <div class="mb-4">
                    <label for="status_produksi" class="block text-sm font-medium text-gray-700 mb-1">Status Produksi</label>
                    <select id="status_produksi" name="status_produksi" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Status</option>
                        <option value="proses" @if ((isset($data_produksi) ? $data_produksi->status_produksi : old('status_produksi')) == 'proses') selected @endif>Proses</option>
                        <option value="selesai" @if ((isset($data_produksi) ? $data_produksi->status_produksi : old('status_produksi')) == 'selesai') selected @endif>Selesai</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 mx-2 rounded text-white font-semibold"
                        style="background-color: #3f4d67;">
                        Simpan
                    </button>
                    <a href="{{ route('produksi.index') }}"
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
