<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-100 to-yellow-100 h-screen flex items-center justify-center">
    <div class="flex bg-white rounded-lg shadow-lg max-w-5xl w-full mx-4">
        <!-- Kolom Ikon -->
        <div class="flex-1 p-10 hidden md:block">
            <img src="{{ asset('assets/shop.jpg') }}" alt="Icon" class="w-full h-auto">
        </div>
        <!-- Kolom Form Login -->
        <div class="flex-1 px-10 py-2">
            <h2 class="text-2xl font-semibold my-3 text-gray-700">Daftar Akun KoperasiKu</h2>
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
            @csrf
                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="name" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-1.5" placeholder="nama lengkap" required>
                </div>
                <div class="mb-2">
                    <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input type="kelas" id="kelas" name="kelas" class="mt-1 block w-full border border-gray-300 rounded-md p-1.5" placeholder="kelas berapa?" required>
                </div>
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md p-1.5" placeholder="email@example.com" required>
                </div>
                <div class="mb-2">
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="mt-1 block w-full border border-gray-300 rounded-md p-1.5" placeholder="Nomor telepon" required>
                </div>
                <div class="mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md p-1.5" placeholder="********" required>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <a href="#" class="text-sm text-blue-400">Lupa Kata Sandi</a>
                </div>
                <button type="submit" class="w-full bg-purple-400 text-white font-semibold py-2 rounded-md hover:bg-purple-500">Daftar</button>
            </form>
            <p class="my-3 text-sm text-gray-600">Sudah punya akun? <a href="login" class="text-blue-500">Masuk</a></p>
        </div>
    </div>
</body>
</html>
