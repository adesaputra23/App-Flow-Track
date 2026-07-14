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
                    Qr Code</th>
                <th>
                    Jenis</th>
                <th>
                    Gambar
                </th>
                <th>
                    Jumlah</th>
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
                    <td class="text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=QR-PACKING-ID:{{ $data->id }}"
                            alt="QR Code ID {{ $data->id }}" style="width:48px; height:48px;">
                    </td>
                    <td class="text-center">{{ $data->produksi->detail_pesanan->jenis }}</td>
                    <td class="text-center">
                        @if (!empty($data->produksi->detail_pesanan->image))
                            <img src="{{ asset('storage/pesanan_gambar/' . $data->produksi->detail_pesanan->image) }}"
                                alt="Gambar" style="width:32px; height:32px; object-fit:cover; display:block; margin:auto; border-radius:6px;">
                           
                        @else
                            <span class="text-gray-400 italic">- Tidak ada gambar -</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $data->jumlah_packing }}
                        {{ $data->produksi->detail_pesanan->satuan ?? '' }}</td>
                    <td class="text-center">{{ $data->created_at->format('H:i:s') }}</td>
                    <td class="text-center">{{ $data->created_at->format('Y-m-d') }}</td>
                    <td class="text-center">{{ $data->karyawan->nama_lengkap ?? '-' }}</td>
                    <td class="text-center">{{ $data->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
