<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengeluaran KoperasiKu</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 12px;
        }
        .header { 
            text-align: center; 
            font-size: 10px;
        }
        table {
        width: 100%;
        border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .tanggal {
            width: 25%;
        }
        .deskripsi {
            width: 75%;
        }
        .keterangan-total {
            text-align: right;
        }
    </style>
</head>
<body>
    
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id'); // Set locale ke Indonesia
    @endphp

    <div class="header">
        <h1>Pengeluaran KoperasiKu</h1>
    </div>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th class="tanggal">Tanggal</th>
                    <th class="deskripsi">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tanggal">{{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->translatedFormat('d F Y') }}</td>
                    <td class="deskripsi">{{ $pengeluaran->deskripsi_pengeluaran }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="keterangan-total">
        <p><strong>Total Pengeluaran: Rp. {{ number_format($pengeluaran->total_pengeluaran, 0, ',', '.') }}</strong></p>
    </div>
</body>
</html>