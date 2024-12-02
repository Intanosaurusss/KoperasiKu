@extends('components.layout-admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="p-2">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Hai Admin, selamat datang!</h2>

        <!-- Kotak Informasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total User -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center space-x-3">
                    <div class="text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                            <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">User</h3>
                </div>
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ $totaluser }}</p>
                <p class="text-sm text-gray-500">Ini adalah jumlah user yang menggunakan aplikasi</p>
            </div>

            <!-- Total Pengeluaran -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center space-x-3">
                    <div class="text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                            <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">Pengeluaran</h3>
                </div>
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ $totalpengeluaran }}</p>
                <p class="text-sm text-gray-500">Ini adalah jumlah pengeluaran untuk belanja produk</p>
            </div>

            <!-- Total Pemasukan -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center space-x-3">
                    <div class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                            <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                            <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">Pemasukan</h3>
                </div>
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ number_format($totalpemasukan, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500">Ini adalah jumlah pemasukan dari produk yang terjual</p>
            </div>

            <!-- Total Produk -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center space-x-3">
                    <div class="text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                            <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">Produk</h3>
                </div>
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ $totalproduk }}</p>
                <p class="text-sm text-gray-500">Ini adalah jumlah produk yang tersedia</p>
            </div>

            <!-- Total Riwayat -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center space-x-3">
                    <div class="text-yellow-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">Riwayat</h3>
                </div>
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ $totalriwayat }}</p>
                <p class="text-sm text-gray-500">Ini adalah riwayat pembelian</p>
            </div>

        </div>
    </div>
@endsection
