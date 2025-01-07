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
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 5px;
            font-weight: bold;
            text-align: right;
        }
        .header {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .info {
            margin-top: 10px;
            font-size: 12px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .detail-pembelian {
            text-align: left;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            align-items: center; 
            gap: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .logo {
            width: 50px; 
            height: auto;
        }
    </style>
</head>
<body>

@php
    use Carbon\Carbon;
    Carbon::setLocale('id'); // Set locale ke Indonesia
@endphp

<div class="header">
    <img src="./assets/logo_koperasiku.png" alt="Logo KoperasiKu" class="logo">
    <h1>KoperasiKu</h1>
</div>
<p class="info"><strong>Tanggal Pembelian :</strong> 
    {{ Carbon::parse(request('date_start'))->translatedFormat('d F Y') }} 
    s.d. 
    {{ Carbon::parse(request('date_end'))->translatedFormat('d F Y') }}
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Email</th>
            <th>Detail</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $transaksi)
            <tr>
                <td>{{ $no++ }}</td>
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

<div class="total">
    <strong>Total Pembelian : Rp. {{ number_format($grandTotal, 0, ',', '.') }}</strong>
</div>

<!-- Footer Section -->
<div class="footer">
    <p>Terima Kasih</p>
    <p>Selamat Berbelanja Kembali</p>
</div>


</body>
</html>
