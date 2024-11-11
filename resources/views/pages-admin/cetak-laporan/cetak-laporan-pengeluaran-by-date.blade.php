<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengeluaran</title>
    @vite('resources/css/app.css')
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 class="text-center font-semibold">Laporan Pengeluaran</h2>
    <p>Tanggal: {{ $dateStart }} s.d. {{ $dateEnd }}</p>

    <table>
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

    <p class="font-semibold justify-end">Total Pengeluaran : Rp.{{ number_format($totalPengeluaran, 0, ',', '.') }} </p>

</body>
</html>
