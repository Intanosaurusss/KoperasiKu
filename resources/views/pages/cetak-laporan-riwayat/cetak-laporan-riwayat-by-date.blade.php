<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi by Date</title>
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
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-top: 10px;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    @php
        use Carbon\Carbon;
        Carbon::setLocale('id'); // Set locale ke Indonesia
    @endphp

    <h1 class="header">KoperasiKu</h1>
    <p class="info"><strong>Email:</strong> {{ $data->first()['email'] ?? 'nama kamu siapa?' }}</p>
    <p class="info"><strong>Tanggal:</strong> 
        {{ Carbon::parse(request('date_start'))->translatedFormat('d F Y') }} 
        s.d. 
        {{ Carbon::parse(request('date_end'))->translatedFormat('d F Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pembelian</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;
                $no = 1;
            @endphp
            @foreach ($data as $transaksi)
                @foreach ($transaksi['riwayat'] as $riwayat)
                    @php
                        $grandTotal += $riwayat['subtotal'];
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ Carbon::parse($transaksi['tanggal'])->translatedFormat('d F Y') }}</td>
                        <td>{{ $riwayat['produk'] }}</td>
                        <td>{{ $riwayat['qty'] }}</td>
                        <td>Rp {{ number_format($riwayat['harga'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($riwayat['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>  
    </table>

        <div style="text-align: right;">
            <strong>Total Belanja: Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong>
        </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>Terima Kasih</p>
        <p>Selamat Belanja Kembali</p>
    </div>

</body>
</html>
