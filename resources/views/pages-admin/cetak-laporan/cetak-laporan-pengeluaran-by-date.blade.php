<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengeluaran by Date</title>
    @vite('resources/css/app.css')
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 13px;
        }
        .pengeluaran-table {
        width: 100%;
        border-collapse: collapse;
        }
        .pengeluaran-table th {
            border: 1px solid #000;
            padding: 8px;
            text-align: left; 
            background-color: #f2f2f2; 
        }
        .pengeluaran-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left; 
        }

        .pengeluaran-table th:nth-child(1),
        .pengeluaran-table td:nth-child(1) {
            width: 25%; /* Lebar kolom Tanggal Pengeluaran */
        }

        .pengeluaran-table th:nth-child(2),
        .pengeluaran-table td:nth-child(2) {
            width: 25%; /* Lebar kolom Total Pengeluaran */
        }

        .pengeluaran-table th:nth-child(3),
        .pengeluaran-table td:nth-child(3) {
            width: 50%; /* Lebar kolom Deskripsi */
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
        .keterangan-total {
            text-align: right;
            margin-top: 10px;
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
                <td style="gap: 2px; vertical-align: middle; border: none;">
                    <img src="./assets/logo_koperasiku.png" alt="Logo KoperasiKu" style="display: block; width: 55px; height: auto;" />
                </td>
                <td style="vertical-align: middle; border: none;">
                    <h1 style="margin: 0; font-size: 15px; font-weight: bold;">Laporan Pengeluaran KoperasiKu</h1>
                </td>
            </tr>
        </table>
    </div>

    <p>Tanggal: {{ Carbon::parse($dateStart)->translatedFormat('d F Y') }} s.d. {{ Carbon::parse($dateEnd)->translatedFormat('d F Y') }}</p>

    <table class="pengeluaran-table">
        <thead>
            <tr>
                <th>Tanggal Pengeluaran</th>
                <th>Total Pengeluaran</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pengeluaran as $item)
            <tr>
                <td>{{ $item->tanggal_pengeluaran }}</td>
                <td>Rp. {{ number_format($item->total_pengeluaran, 0, ',', '.') }}</td>
                <td>{{ $item->deskripsi_pengeluaran }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="keterangan-total">
        <strong>Total Pengeluaran : Rp.{{ number_format($totalPengeluaran, 0, ',', '.') }} </strong>
    </div>

</body>
</html>
