<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Hasil Produksi</title>
    <style>
        /* Set landscape orientation for printing or PDF generation */
        @page {
            size: A4 landscape;
            margin: 20mm 15mm 20mm 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
        }

        th,
        td {
            border: 1px solid #888;
            padding: 6px 4px;
            font-size: 11px;
        }

        th {
            background: #f6f6f6;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Data Hasil Produksi</h2>
    @if (request('tanggal_awal') && request('tanggal_akhir'))
        <p style="text-align: center; margin-top: 2px; margin-bottom: 0;">
            <small>
                Periode:
                <strong>
                    {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d-m-Y') }}
                    s/d
                    {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d-m-Y') }}
                </strong>
            </small>
        </p>
    @endif
    <table>
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>
                    Kode</th>
                <th>
                    Instansi</th>
                <th>
                    Jenis</th>
                <th>
                    Gambar
                </th>           
                <th>
                    Jumlah</th>
                <th>
                    Bahan Baku
                </th>
                <th>
                    Jam</th>
                <th>
                    Tanggal</th>
                <th>
                    Petugas</th>
                <th>
                    Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_data as $i => $data)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $data->kode }}</td>
                    <td class="text-center">{{ $data->detail_pesanan->pesanan->instansi }}</td>
                    <td class="text-center">{{ $data->detail_pesanan->jenis }}</td>
                    <td class="text-center">
                        @if (!empty($data->detail_pesanan->image))
                            <img src="{{ public_path('storage/pesanan_gambar/' . $data->detail_pesanan->image) }}" alt="Gambar" style="height: 40px; width: 40px; object-fit: cover; border-radius: 6px;">
                        @else
                            <span style="color: #aaa; font-style: italic;">- Tidak ada gambar -</span>
                        @endif
                    </td>               
                    <td class="text-center">{{ $data->detail_pesanan->jumlah }} {{ ($data->detail_pesanan->satuan ?? '') }}</td>
                    <td class="text-center">
                        <ul class="">
                            @forelse ($data->detail_bahan_baku as $key => $detail)
                                <li>{{ $key + 1 }}. {{ $detail->bahan_baku->nama_bahan ?? '-' }} -
                                    {{ $detail->jumlah_bahan }} {{ $detail->bahan_baku->satuan }}</li>
                            @empty
                                <li>-</li>
                            @endforelse
                        </ul>
                    </td>
                    <td class="text-center">{{ $data->jam_produksi }}</td>
                    <td class="text-center">{{ $data->created_at->format('Y-m-d') }}</td>
                    <td class="text-center">{{ $data->karyawan->nama_lengkap ?? '-' }}</td>
                    <td class="text-center">{{ $data->status_produksi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
