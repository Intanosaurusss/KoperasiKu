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

            <form action="{{ route('login') }}" method="POST" id="form">
            @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300  focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md p-2" placeholder="email@example.com" required>
                </div>
                <div class="mb-4">
                    <label for="id_member" class="block text-sm font-medium text-gray-700">ID Member</label>
                    <div class="relative">
                        <input type="number" name="id_member" id="id_member" class="mt-1 block w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md p-2 pr-10" placeholder="Masukkan ID Member" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')" required>
                        <button type="button" onclick="toggleVisibility()" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" id="btn-submit" class="inline-flex justify-center items-center w-full bg-purple-400 text-white font-semibold py-2 rounded-md hover:bg-purple-500 transition duration-200">
                    Masuk
                </button>
            </form>
        </div>
    </div>

<script>
    // untuk mengatur button "masuk" saat sedang loading
    const form = document.getElementById('form');
    form.addEventListener('submit', function (e) {
        const buttonSubmit = document.getElementById('btn-submit');
        
        // Ubah teks tombol ke loading state
        buttonSubmit.innerHTML =
            '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading';
        
        // Tambahkan atribut disabled
        buttonSubmit.setAttribute('disabled', true);
        
        // Tambahkan kelas untuk menonaktifkan hover dan pointer
        buttonSubmit.classList.add('cursor-not-allowed', 'bg-purple-400');
        buttonSubmit.classList.remove('hover:bg-purple-500');
    });

    // function untuk mengatur form input id member menggunakan icon agar lebih dinamis
    function toggleVisibility() {
    const input = document.getElementById('id_member');
    const eyeIcon = document.getElementById('eyeIcon');

    if (input.type === 'password') { //untuk melihat id member
        input.type = 'text';
        eyeIcon.innerHTML = `
            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
            <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />
        `;
    } else {
        input.type = 'password'; // untuk menyembunyikan id member
        eyeIcon.innerHTML = `
            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
        `;
    }
    }
</script>
</body>
</html>
