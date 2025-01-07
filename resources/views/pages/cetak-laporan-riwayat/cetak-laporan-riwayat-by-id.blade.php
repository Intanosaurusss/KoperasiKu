<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi by Id Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
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
        .info {
            margin-bottom: 10px;
        }
        .info p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
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
        Carbon::setLocale('id'); // Set locale ke Indonesia, format untuk tanggalnya
    @endphp

    <!-- Header Section -->
    <div class="header">
        <img src="./assets/logo_koperasiku.png" alt="Logo KoperasiKu" class="logo">
        <h1>KoperasiKu</h1>
    </div>

    <!-- User Info Section -->
    <div class="info">
        <p>Email: {{ $email }}</p>
        <p>Tanggal: {{ Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
    </div>

    <!-- <hr style="border: 1px dashed;"> -->

    <!-- Table Section -->
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $item)
                <tr>
                    <td>{{ $item['produk'] }}</td>
                    <td class="text-center">{{ $item['qty'] }}</td>
                    <td class="text-right">Rp.{{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp.{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- <hr style="border: 1px dashed;"> -->

    <!-- Total Section -->
    <div style="text-align: right;">
        <strong>Total Belanja : Rp.{{ number_format($total, 0, ',', '.') }}</strong>
    </div>

    <!-- <hr style="border: 1px dashed;"> -->

    <!-- Footer Section -->
    <div class="footer">
        <p>Terima Kasih</p>
        <p>Selamat Berbelanja Kembali</p>
    </div>
</body>
</html>
