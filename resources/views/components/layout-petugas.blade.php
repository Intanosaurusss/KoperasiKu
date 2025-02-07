<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script> <!-- import tailwind  (pake CDN juga soalnya pas di hosting ga muncul style nya) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> <!-- import alphine untuk layout responsivenya -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Wrapper -->
    <div class="flex h-screen" x-data="{ sidebarOpen: false }">

        <!-- Sidebar -->
        <div 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transition-transform transform lg:translate-x-0 lg:static z-50">
            <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
            <!-- foto profile, ditambahin Auth::guard('admin') -> (ditambahin sama mas Roy) karena role nya admin (menggunakan middleware) -->
            <a href="{{ route('profile', ['id' => Auth::guard('petugas')->id()]) }}" class="inline-block ml-4">
                <img 
                    src="{{ Auth::guard('petugas')->user()->foto_profile ? asset('storage/' . Auth::guard('petugas')->user()->foto_profile) : asset('assets/default-profile.jpg') }}"
                    alt="Profile Petugas" 
                    class="w-12 h-12 rounded-full object-cover"
                />
            </a>

                <!-- Kontainer teks user dan user2, disusun vertikal. ditambahin Auth::guard('admin') -> (ditambahin sama mas Roy) karena role nya admin (menggunakan middleware)-->
                <div class="ml-2 flex flex-col">
                    <p class="font-medium">{{ Str::limit(Auth::guard('petugas')->user()->nama, 10, '...') }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::guard('petugas')->user()->role }}</p>
                </div>
            </div>

            <!-- button x menutup sidebar -->
                <button 
                    @click="sidebarOpen = false" 
                    class="lg:hidden p-2 rounded-md bg-purple-100 text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="">
                <ul class="ml-4 mr-4 space-y-2 mt-2 text-gray-800">
                    
                <a href="{{ route('pages-petugas.dashboard-petugas') }}" class="block">
                    <li class="flex items-center px-4 py-2 hover:bg-purple-200 rounded-xl space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                            <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                        </svg>
                        <span>Dashboard</span>
                    </li>
                </a>
                
                <a href="#" class="block">
                    <li class="flex items-center px-4 py-2 hover:bg-purple-200 rounded-xl space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z" clip-rule="evenodd" />
                        <path d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                    </svg>
                        <span>Transaksi</span>
                    </li>
                </a>

                <a href="#" class="block">
                    <li class="flex items-center px-4 py-2 hover:bg-purple-200 rounded-xl space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                        </svg>
                        <span>Riwayat</span>
                    </li>
                </a>

                <a href="#" class="block"class="block">
                    <li class="flex items-center px-4 py-2 hover:bg-red-200 rounded-xl space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-5 h-5" viewBox="0 0 50 50" fill="currentColor">
                            <path d="M46.137,6.552c-0.75-0.636-1.928-0.727-3.146-0.238l-0.002,0C41.708,6.828,6.728,21.832,5.304,22.445c-0.259,0.09-2.521,0.934-2.288,2.814c0.208,1.695,2.026,2.397,2.248,2.478l8.893,3.045c0.59,1.964,2.765,9.21,3.246,10.758c0.3,0.965,0.789,2.233,1.646,2.494c0.752,0.29,1.5,0.025,1.984-0.355l5.437-5.043l8.777,6.845l0.209,0.125c0.596,0.264,1.167,0.396,1.712,0.396c0.421,0,0.825-0.079,1.211-0.237c1.315-0.54,1.841-1.793,1.896-1.935l6.556-34.077C47.231,7.933,46.675,7.007,46.137,6.552z M22,32l-3,8l-3-10l23-17L22,32z"></path>
                        </svg>
                        <span>Saran</span>
                    </li>
                </a>

                <a href="{{ route ('logout.petugas') }}" class="block"class="block">
                <li id="#" class="flex items-center px-4 py-2 hover:bg-red-200 rounded-xl space-x-4 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    <span>Logout</span>
                </li></a>

                </ul>
            </nav>
        </div>

        <!-- Overlay (untuk layar kecil) -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 lg:hidden"></div>

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white shadow p-4 flex items-center justify-start">
                <!-- button ☰ membuka sidebar -->
                <button 
                    @click="sidebarOpen = true" 
                    class="lg:hidden p-2 bg-purple-100 text-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <h5 class="text-md font-semibold pl-2 text-gray-700">@yield('title')</h5>
                <!-- Icon Notifikasi -->
                <div class="relative ml-auto">
                    <button class="text-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
                        <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z" clip-rule="evenodd" />
                    </svg>
                    </button>
                    <!-- Indikator Notifikasi dengan jumlah yang belum dibaca -->
                    <span class="absolute top-0 right-0 inline-block w-3 h-3 bg-red-500 rounded-full hidden flex items-center justify-center" id="notification-badge">
                        <span id="notification-count" class="text-[10px] text-white font-bold"></span>
                    </span>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationButton = document.querySelector('.relative.ml-auto button');
        const notificationBadge = document.querySelector('.relative.ml-auto span');
        const notificationList = document.createElement('div');

        // Tambahkan class Tailwind untuk scrollbar dan styling
        notificationList.classList.add(
            'absolute', 'top-12', 'right-0', 'bg-white', 'shadow-lg', 
            'w-80', 'rounded-lg', 'p-4', 'hidden', 
            'max-h-64', 'overflow-y-auto' // Tambahan untuk scrollbar
        );
        document.querySelector('.relative.ml-auto').appendChild(notificationList);

        notificationButton.addEventListener('click', () => {
            notificationList.classList.toggle('hidden');

            // Ambil notifikasi dengan AJAX
            fetch("{{ route('notifikasi.fetch') }}")
                .then(response => response.json())
                .then(notifications => {
                    notificationList.innerHTML = ''; // Kosongkan list
                    if (notifications.length > 0) {
                        notifications.forEach(notification => {
                            const item = document.createElement('div');
                            item.classList.add('p-2', 'border-b', 'text-sm', 'hover:bg-gray-100');
                            item.textContent = notification.message;

                            // Tambahkan tombol selesai untuk menandai notifikasi dibaca
                            const selesaiButton = document.createElement('button');
                            selesaiButton.classList.add('text-blue-500', 'ml-2', 'text-xs');
                            selesaiButton.textContent = 'Selesai';
                            selesaiButton.addEventListener('click', () => {
                                // Tandai notifikasi sebagai dibaca dengan mengirim request ke backend
                                fetch(`/notifikasi/mark-as-read/${notification.id}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        // Setelah sukses, hapus item dari daftar notifikasi
                                        item.remove();
                                    }
                                })
                                .catch(error => {
                                    console.error('Error marking notification as read:', error);
                                });
                            });

                            item.appendChild(selesaiButton);
                            notificationList.appendChild(item);
                        });

                        notificationBadge.classList.add('hidden'); // Hilangkan badge
                    } else {
                        notificationList.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada notifikasi baru.</p>';
                    }
                })
                .catch(error => {
                    notificationList.innerHTML = '<p class="text-red-500 text-sm">Gagal memuat notifikasi.</p>';
                    console.error('Error fetching notifications:', error);
                });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Cek jumlah notifikasi yang belum dibaca
        fetch("/notifikasi/check-unread")
            .then(response => response.json())
            .then(data => {
                const notificationBadge = document.getElementById('notification-badge');
                const notificationCount = document.getElementById('notification-count');
                
                // Jika ada notifikasi yang belum dibaca, tampilkan indikator dan jumlahnya
                if (data.unread_count > 0) {
                    notificationBadge.classList.remove('hidden');
                    notificationCount.textContent = data.unread_count;  // Tampilkan jumlah notifikasi
                } else {
                    notificationBadge.classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error fetching unread notifications:', error);
            });
    });
</script>
</body>
</html>
