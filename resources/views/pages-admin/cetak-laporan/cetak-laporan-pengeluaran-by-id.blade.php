<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengeluaran</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; }
        .content { margin: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Pengeluaran</h1>
    </div>
    <div class="content">
        <p><strong>Tanggal Pengeluaran:</strong> {{ $pengeluaran->tanggal_pengeluaran }}</p>
        <p><strong>Deskripsi:</strong> {{ $pengeluaran->deskripsi_pengeluaran }}</p>
        <p><strong>Total Pengeluaran:</strong> Rp {{ $pengeluaran->total_pengeluaran }}</p>
    </div>
</body>
</html>
