@extends('components.layout-petugas')

@section('title', 'Dashboard Petugas')

<!-- import CDN Chartjs untuk membuat grafik batang responsive (line 89) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<div class="p-2">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Hai {{ Auth::user()->nama }}, selamat bertugas!</h2>

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
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ $totalpemasukan}}</p>
                <p class="text-sm text-gray-500">Ini adalah jumlah pemasukan bulan {{ $bulanini}}</p>
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
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ $totaluser }}</p>
                <p class="text-sm text-gray-500">Ini adalah jumlah produk yang tersedia berdasarkan produknya</p>
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
                <p class="text-3xl font-bold mt-2 text-gray-700">{{ $totalriwayat}}</p>
                <p class="text-sm text-gray-500">Ini adalah total riwayat pembelian</p>
            </div>
        </div>

       <!-- Produk Terlaris dan Member Terroyal -->
    <div class="mt-6">
        <!-- Container Tabel -->
        <div class="flex flex-col md:flex-row justify-between gap-4">
            <!-- Tabel 1 : Produk Terlaris -->
            <div class="w-full md:w-1/2 overflow-x-auto rounded-lg bg-white px-2 py-2 shadow-md">
                <h2 class="text-lg font-medium text-center mb-2 text-gray-700">Produk Terlaris Bulan {{ $bulanini }}</h2>
                    <table class="min-w-full text-sm border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 font-semibold text-gray-700 border">No</th>
                                <th class="px-2 py-2 font-semibold text-gray-700 border">Produk</th>
                                <th class="px-2 py-2 font-semibold text-gray-700 border">Total Terjual</th>
                            </tr>
                        </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse ($produkterlaris as $index => $item)
                            <tr class="hover:bg-gray-100">
                                <td class="px-2 py-2 text-center text-gray-700 border">{{ $index + 1 }}</td>
                                <td class="px-2 py-2 text-gray-700 border">{{ $item->produk->nama_produk ?? 'Tidak Diketahui' }}</td>
                                <td class="px-2 py-2 text-gray-700 border text-center">{{ $item->total_qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-2 py-2 text-center text-gray-700">Tidak ada data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
            </div>

                <!-- Tabel 2 : Member teroyall-->
                <div class="w-full md:w-1/2 overflow-x-auto rounded-lg bg-white px-2 py-2 shadow-md">
                    <h2 class="text-lg font-medium text-center mb-2 text-gray-700">Member Terbanyak Belanja Bulan {{ $bulanini }}</h2>
                    <table class="min-w-full text-sm border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 font-semibold text-gray-700 border">No</th>
                                <th class="px-2 py-2 font-semibold text-gray-700 border">ID Member</th>
                                <th class="px-2 py-2 font-semibold text-gray-700 border">Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse ($memberterroyal as $index => $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-2 py-2 text-center text-gray-700 border">{{ $index + 1 }}</td>
                                    <td class="px-2 py-2 text-gray-700 border">{{ $item->id_member }}</td>
                                    <td class="px-2 py-2 text-gray-700 border">Rp. {{ number_format($item->total_belanja, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-2 py-2 text-center text-gray-700">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>


@endsection
