@extends('app')
@section('title', 'Tambah Item')
@section('content')
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow border">
            <h3 class="text-lg font-bold mb-4">{{ 'Tambah Item' }}</h3>

            @if (session('error'))
                <div class="mb-4">
                    <div class="bg-red-500 border border-red-700 text-white px-4 py-3 rounded relative">
                        <span class="block sm:inline"
                            style="background-color: red; color: white;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('pesanan.simpan.item', $pesanan->id) }}" method="POST">
                @csrf

                @if (isset($detail_pesanans) && count($detail_pesanans) > 0)
                    @foreach ($detail_pesanans as $i => $detail)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4 shadow-inner" id="{{ $detail->id }}">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-1">
                                    <label for="jenis_{{ $i }}" class="block text-gray-700 font-semibold mb-2">Jenis</label>
                                    <input type="text" name="jenis[]" id="jenis_{{ $i }}"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        value="{{ old('jenis.' . $i, $detail->jenis) }}"
                                        required>
                                    @error('jenis.' . $i)
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex-1">
                                    <label for="jumlah_{{ $i }}" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                                    <input type="number" name="jumlah[]" id="jumlah_{{ $i }}" min="1"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        value="{{ old('jumlah.' . $i, $detail->jumlah) }}"
                                        required>
                                    @error('jumlah.' . $i)
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex mt-4 justify-end">
                                <button type="button" data-id="{{ $detail->id }}" class="btn-remove-item-detail bg-red-600 text-white px-2 py-1 text-sm rounded hover:bg-red-700 transition-colors duration-150" style="background-color: #dc2626;">
                                    Hapus Item
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4 shadow-inner">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="flex-1">
                                <label for="jenis_0" class="block text-gray-700 font-semibold mb-2">Jenis</label>
                                <input type="text" name="jenis[]" id="jenis_0"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="{{ old('jenis.0') }}" required>
                                @error('jenis.0')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="jumlah_0" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                                <input type="number" name="jumlah[]" id="jumlah_0" min="1"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="{{ old('jumlah.0') }}" required>
                                @error('jumlah.0')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <div class="new-item"></div>

                <div class="flex mb-4">
                    <button id="add-item" class="px-2 py-1 text-sm rounded text-white font-semibold"
                        style="background-color: #4ade80;">
                        Tambah Item
                    </button>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 mx-2 rounded text-white font-semibold"
                        style="background-color: #3f4d67;">
                        Simpan
                    </button>
                    <a href="{{ route('pesanan.index') }}"
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

    <script>
        $(document).ready(function() {

            $('#add-item').on('click', function(e) {
                e.preventDefault();
                // INSERT_YOUR_CODE
                // INSERT_YOUR_CODE

                // Ambil HTML dari form item (baris 45-73 -- div bg-gray-50 ... </div>)
                let itemHtml = `
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4 shadow-inner new-item">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-1">
                                    <label for="jenis" class="block text-gray-700 font-semibold mb-2">Jenis</label>
                                    <input type="text" name="jenis[]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                </div>
                                <div class="flex-1">
                                    <label for="jumlah" class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                                    <input type="number" name="jumlah[]" min="1" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                </div>
                            </div>
                            <div class="flex mt-4 justify-end">
                                <button type="button" class="btn-remove-item bg-red-600 text-white px-2 py-1 text-sm rounded hover:bg-red-700 transition-colors duration-150" style="background-color: #dc2626;">
                                    Hapus Item
                                </button>
                            </div>
                        </div>
                `;

                // Tambahkan form item ke sebelum tombol "Tambah Item"
                $(itemHtml).insertBefore($(this).closest('.flex.mb-4'));

                // Listener hapus untuk item yang baru ditambahkan
                $(document).off('click', '.btn-remove-item').on('click', '.btn-remove-item', function(e) {
                    e.preventDefault();
                    $(this).closest('.new-item').remove();
                });

            })

            // INSERT_YOUR_CODE
            // Hapus hanya elemen .new-item yang diklik
            $(document).on('click', '.btn-remove-item', function(e) {
                e.preventDefault();
                $(this).closest('.new-item').remove();
            });

            $(document).on('click', '.btn-remove-item-detail', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#'+id).remove();
            });


        });
    </script>

@endsection
