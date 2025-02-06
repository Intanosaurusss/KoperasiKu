<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Member Anda</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="max-width: 600px; background-color: #fff; padding: 20px; margin: auto; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Selamat, Pendaftaran Berhasil!</h2>
        <p>Halo <strong>{{ $user->nama }}</strong>,</p>
        <p>Anda telah berhasil mendaftar sebagai member. Berikut ID Member Anda:</p>
        <h3 style="text-align: center; padding: 10px; background-color: #007bff; color: white; border-radius: 5px;">
            {{ $user->id_member }}
        </h3>
        <p>Simpan ID ini dengan baik, karena akan digunakan untuk login atau keperluan lainnya.</p>
        <p>Terima kasih telah bergabung!</p>
        <p>Salam,<br>Tim Koperasiku</p>
    </div>
</body>
</html>
