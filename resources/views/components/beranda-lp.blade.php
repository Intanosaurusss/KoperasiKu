<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
<section id="beranda" class="bg-white">
    <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
        <img class="w-auto h-auto mt-10 animate-ping-and-bounce" src="{{ asset('assets/shop.jpg') }}" alt="dashboard image">
        <div class="mt-4 md:mt-0">
            <h2 class="mb-4 text-2xl md:text-4xl tracking-tight font-bold text-purple-400 shadow-white">Belanja Jadi Mudah</h2>
            <p class="text-gray-700 mb-4">KoperasiKu adalah aplikasi koperasi sekolah yang mempermudah pengelolaan transaksi dan laporan keuangan secara digital. Dengan desain yang efisien, KoperasiKu membantu mengelola koperasi secara lebih terkontrol dan mudah diakses kapan saja.</p>
            <div class="grid grid-cols-3 gap-2">
            <a href="login" class="inline-flex items-center justify-center text-center text-purple-400 border-2 border-purple-400 hover:text-white hover:bg-purple-400 font-medium rounded-full text-sm py-2 w-auto">
                Mulai
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ml-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
            </div>
        
        <!-- penutup container div yang paling atas -->
        </div>
    </div>
</section>
</body>
</html>