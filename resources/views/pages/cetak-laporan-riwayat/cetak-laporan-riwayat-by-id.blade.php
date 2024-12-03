<!DOCTYPE html>
<html lang="en">
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
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
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
    <!-- Header Section -->
    <div class="header">
        <h1>KoperasiKu</h1>
    </div>

    <!-- User Info Section -->
    <div class="info">
        <p>Email: {{ $email }}</p>
        <p>Tanggal: {{ $tanggal }}</p>
    </div>

    <hr style="border: 1px dashed;">

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

    <hr style="border: 1px dashed;">

    <!-- Total Section -->
    <div style="text-align: right;">
        <strong>Total: Rp.{{ number_format($total, 0, ',', '.') }}</strong>
    </div>

    <hr style="border: 1px dashed;">

    <!-- Footer Section -->
    <div class="footer">
        <p>Terima Kasih</p>
        <p>Selamat Belanja Kembali</p>
    </div>
</body>
</html>
