<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            border: 1px solid black;
            padding: 8px;
        }
        .header-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .judul {
            text-align: center;
        }
    </style>
</head>
<body>
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id'); // Set locale ke Indonesia
    @endphp

    <!-- Header Section -->
    <div class="header">
        <table style="margin: 0 auto; text-align: center; border-collapse: collapse; border: none; width: auto;">
            <tr class="border: none;">
                <td style="gap: 6px; vertical-align: middle; border: none;">
                    <img src="./assets/logo_koperasiku.png" alt="Logo KoperasiKu" style="display: block; width: 55px; height: auto;" />
                </td>
                <td style="vertical-align: middle; border: none;">
                    <h1 style="margin: 0; font-size: 20px; font-weight: bold;">KoperasiKu</h1>
                </td>
            </tr>
        </table>
    </div>

    <p class="info"><strong>Petugas:</strong> {{ $namaPetugas }}</p>
    <p class="info"><strong>Tanggal:</strong> 
        {{ Carbon::parse(request('date_start'))->translatedFormat('d F Y') }} 
        s.d. 
        {{ Carbon::parse(request('date_end'))->translatedFormat('d F Y') }}
    </p>

    <table>
        <thead>
            <tr class="judul">
                <th>No</th>
                <th>Tanggal</th>
                <th>Email</th>
                <th>Detail</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $transaksi)
                <tr>
                    <td>{{ $transaksi['index'] }}</td>
                    <td>{{ Carbon::parse($transaksi['tanggal'])->translatedFormat('d F Y') }}</td>
                    <td>{{ $transaksi['email'] }}</td>
                    <td class="detail-pembelian">
                        <ul>
                            @foreach ($transaksi['riwayat'] as $riwayat)
                                <li>
                                    <strong>Produk:</strong> {{ $riwayat['produk'] }} 
                                    <strong>Qty:</strong> {{ $riwayat['qty'] }} 
                                    <strong>Harga:</strong> Rp. {{ number_format($riwayat['harga'], 0, ',', '.') }}
                                    <strong>Subtotal:</strong> Rp. {{ number_format($riwayat['subtotal'], 0, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>Rp. {{ number_format($transaksi['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: right; font-size: 13px; margin-top: 10px;">
        <strong>Total Belanja: Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>Terima Kasih</p>
        <p>Selamat Berbelanja Kembali</p>
    </div>

</body>
</html>
