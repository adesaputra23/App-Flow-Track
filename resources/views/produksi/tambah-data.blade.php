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

                <div class="mb-4 div-bahan-baku">
                    <label for="id_bahan" class="block text-sm font-medium text-gray-700 mb-1">Bahan Produksi</label>
                    <select id="id_bahan" name="id_bahan[]" class="w-full p-2 border rounded select2 bahan-baku" multiple="multiple" required>
                        @if(isset($bahan_list) && count($bahan_list) > 0)
                            @foreach($bahan_list as $bahan)
                                <option value="{{ $bahan->id }}"
                                    @if(
                                        (isset($data_produksi) && (
                                            (is_array($data_produksi->id_bahan_baku ?? null) && in_array($bahan->id, $data_produksi->id_bahan_baku))
                                            || (!is_array($data_produksi->id_bahan_baku ?? null) && $data_produksi->id_bahan_baku == $bahan->id)
                                        ))
                                        || (is_array(old('id_bahan')) && in_array($bahan->id, old('id_bahan')))
                                        || (isset($detail_bahan_baku) && in_array($bahan->id, (array) $detail_bahan_baku))
                                    )
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
                    <label for="jumlah_gagal_produksi" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Perbatang Gagal Produksi</label>
                    <input type="number" min="0" id="jumlah_gagal_produksi" name="jumlah_gagal_produksi" class="w-full p-2 border rounded" required
                        value="{{ isset($data_produksi) ? $data_produksi->jumlah_batang_gagal_produksi : old('jumlah_gagal_produksi') }}">
                </div>

                <div class="mb-4">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="w-full p-2 border rounded" required
                        value="{{ isset($data_produksi) ? $data_produksi->tanggal : old('tanggal', date('Y-m-d')) }}">
                </div>

                <div class="mb-4">
                    <label for="jam_produksi" class="block text-sm font-medium text-gray-700 mb-1">Jam Produksi</label>
                    <input type="time" id="jam_produksi" name="jam_produksi" class="w-full p-2 border rounded" readonly 
                        value="{{ date('H:i') }}">
                </div>

                <div class="mb-4">
                    <label for="id_petugas" class="block text-sm font-medium text-gray-700 mb-1">Petugas</label>
                    <select id="id_petugas" name="id_petugas" class="w-full p-2 border rounded" required>
                        <option value="">Pilih Petugas</option>
                        @if(isset($karyawan_list) && count($karyawan_list) > 0)
                            @foreach($karyawan_list as $karyawan)
                                <option value="{{ $karyawan->id }}"
                                    @if(
                                        (isset($data_produksi) && $data_produksi->p_jawab == $karyawan->id)
                                        || (old('id_petugas') == $karyawan->id)
                                    )
                                        selected
                                    @endif
                                >
                                    {{ $karyawan->nama_lengkap ?? 'Petugas ' . $karyawan->id }}
                                </option>
                           
                            @endforeach
                        @endif
                    </select>
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.select2').select2({
            placeholder: "Pilih Bahan Produksi",
            allowClear: true,
            width: '100%'
        });
    });

    // INSERT_YOUR_CODE
    // Mendapatkan data yang dipilih pada elemen .select2
    function getSelectedBahan() {
        var selected = $('.select2').val();
        var selectedTexts = [];
        $('.select2 option:selected').each(function() {
            selectedTexts.push($(this).text());
        });
    $(document).ready(function() {
        var selectedValues = $('.select2').val();
        // Hapus field jumlah yang sudah ada agar tidak duplikat
        $("[id^='input-jumlah-']").remove();

        if(selectedValues && selectedValues.length > 0) {
            selectedValues.forEach(function(val) {
                var optionText = $('.select2').find("option[value='" + val + "']").text();
                var jumlahVal = '';
                @if(isset($data_produksi) && isset($data_produksi->detail_bahan_baku))
                    let detail = @json($data_produksi->detail_bahan_baku->keyBy('id_bahan_baku'));
                    if(detail[val]) {
                        jumlahVal = detail[val].jumlah_bahan;
                    }
                @endif
                var html = `
                    <div class="mb-4" id="input-jumlah-${val}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah untuk ${optionText}</label>
                        <input type="number" name="jumlah_bahan[${val}]" min="0" step="any" class="w-full p-2 border rounded" required value="` + (jumlahVal ? jumlahVal : '') + `">
                    </div>
                `;
                $(html).insertAfter($('.div-bahan-baku').first());
            });
        }
    });
        
    }
    getSelectedBahan();

    $('.select2').on('select2:select', function (e) {
        var selectedValue = $(this).val();
        var selectedText = $(this).find("option:selected").text();
        $("[id^='input-jumlah-']").remove();

        // Untuk setiap bahan yang dipilih (bisa multiple select), tambahkan field jumlah
        var selectedValues = $(this).val();
        if(selectedValues && selectedValues.length > 0) {
            selectedValues.forEach(function(val) {
                var optionText = $(e.target).find("option[value='" + val + "']").text();
                var html = `
                    <div class="mb-4" id="input-jumlah-${val}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah untuk ${optionText}</label>
                        <input type="number" name="jumlah_bahan[${val}]" min="0" step="any" class="w-full p-2 border rounded" required>
                    </div>
                `;
                $(html).insertAfter($('.div-bahan-baku').first());
            });
        }
    });
</script>
@endsection
