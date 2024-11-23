<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
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
        <div class="flex-1 p-10">
            <h2 class="text-2xl font-semibold mb-5 text-gray-700">Masuk Akun KoperasiKu</h2>

            <!-- Tampilkan Error -->
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
            @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="email@example.com" required>
                </div>
                <div class="mb-4">
                    <label for="id_member" class="block text-sm font-medium text-gray-700">ID Member</label>
                    <input type="number" name="id_member" id="id_member" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Masukkan ID Member" required>
                </div>
                <!-- <div class="flex justify-between items-center mb-4">
                    <a href="#" class="text-sm text-blue-500">Lupa Kata Sandi</a>
                </div> -->
                <button type="submit" class="w-full bg-purple-400 text-white font-semibold py-2 rounded-md hover:bg-purple-500">Masuk</button>
            </form>
            <!-- <p class="mt-4 text-sm text-gray-600">Belum punya akun? <a href="register" class="text-blue-500">Daftar</a></p> -->
        </div>
    </div>
</body>
</html>
