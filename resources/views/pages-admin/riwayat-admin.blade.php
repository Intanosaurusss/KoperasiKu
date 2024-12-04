@extends('components.layout-admin')

@section('title', 'Riwayat Admin')

@section('content')
<div class="p-2">
    <div class="flex items-center p-4 mb-4 text-sm text-purple-700 rounded-lg bg-purple-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
    <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman riwayat pembelian
        </div>
    </div>

<div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-sm">
    <!-- searchbar -->
    <div class="flex flex-col md:flex-row items-center mt-4 w-full space-y-3">
        <div class="flex order-1 md:order-1 w-full">
            <form method="GET" action="{{ route('riwayat-admin.index') }}" id="search-form" class="w-full mr-2 md:w-auto space-x-4">
                    <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                        <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <input type="search" name="search" id="default-search" value="{{ request('search') }}" class="block w-full p-2 pl-2 text-sm text-gray-900 border-0 rounded-lg focus:ring-blue-500 focus:outline-none" placeholder="Cari riwayat..." required />
                    </div>
            </form>
        </div>

        <!-- input date awal dan akhir beserta tombol cetak -->
        <form class="flex items-center md:pl-2 ml-auto order-2 md:order-1">
        <input type="date" name="date_start" class="border border-gray-300 rounded-lg p-1.5 text-sm" placeholder="Tanggal Awal" required />
        <span class="mx-2">s.d.</span>
        <input type="date" name="date_end" class="border border-gray-300 rounded-lg p-1.5 text-sm" placeholder="Tanggal Akhir" required />
        @if(session('error'))
            <script>
                // Tampilkan pesan error dalam popup
                window.onload = function() {
                    alert("{{ session('error') }}");
                };
            </script>
        @endif
        <button type="submit" class="bg-blue-400 hover:bg-blue-500 p-1.5 rounded-md flex items-center ml-4 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
            Cetak
        </button>
        </form>    
    </div>

    <!-- Tabel Responsif -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-2 font-semibold text-gray-700">No</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Email</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Tanggal</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @if($transaksi->isEmpty())
                    <!-- Tampilkan pesan jika tidak ada data setelah pencarian -->
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-700">
                            Belum ada riwayat nih, kamu belum jajan di KoperasiKu ya?
                        </td>
                    </tr>
                    @else
            @foreach ($transaksi as $item)
                <tr>
                    <td class="px-4 py-2 text-sm text-center text-gray-700">1</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->user->email ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->created_at->format('d-m-Y') }}</td>
                    <td class="flex px-6 py-2 whitespace-nowrap text-sm text-gray-900 space-x-2 md:space-x-6 justify-center">
                        @include('components.crud-riwayat-admin', ['item' => $item])
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Pagination -->
<div class="mt-4 flex justify-end space-x-2">
        <!-- Tombol Previous -->
        @if ($transaksi->onFirstPage())
            <span class="px-3 py-1 bg-gray-300 text-gray-500 text-sm rounded cursor-default">
                Previous
            </span>
        @else
            <a href="{{ $transaksi->previousPageUrl() }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">
                Previous
            </a>
        @endif
        <!-- Tombol Halaman Dinamis -->
        @php
            $currentPage = $transaksi->currentPage();
            $lastPage = $transaksi->lastPage();

            // Tentukan dua tombol nomor halaman secara dinamis
            $start = max(1, $currentPage - 1);
            $end = min($lastPage, $currentPage + 1);
        @endphp
        <!-- Tampilkan dua tombol halaman yang sesuai -->
        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $currentPage)
                <span class="px-3 py-1 bg-blue-500 text-white text-sm rounded">{{ $page }}</span>
            @else
                <a href="{{ $transaksi->url($page) }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
            @endif
        @endfor
        <!-- Tombol Next -->
        @if ($transaksi->hasMorePages())
            <a href="{{ $transaksi->nextPageUrl() }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">
                Next
            </a>
        @else
            <span class="px-3 py-1 bg-gray-300 text-gray-500 text-sm rounded cursor-default">
                Next
            </span>
        @endif
    </div>
</div>

<!-- Modal Detail  -->
<div class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center">
    <div class="modal-content bg-white rounded-lg shadow-lg p-4 w-full max-w-xs sm:max-w-sm text-sm overflow-y-auto">
        <h2 class="text-center font-bold text-lg mb-2">KoperasiKu</h2>
        <p class="text-center mb-1"></p> <!-- Email -->
        <p class="text-center mb-4"></p> <!-- Tanggal -->

        <hr class="border-t border-dashed mb-4">

        <div class="mb-2">
            <table class="w-full">
                <thead>
                    <tr class="font-semibold">
                        <th class="px-2 py-1 text-left">Produk</th>
                        <th class="px-2 py-1 text-center">Qty</th>
                        <th class="px-2 py-1 text-right">Harga</th>
                        <th class="px-2 py-1 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="produk-list"></tbody>
            </table>
        </div>

        <hr class="border-t border-dashed my-4">

        <div class="flex justify-between">
            <span><strong>Total:</strong></span>
            <span class="total"><strong>Rp.0</strong></span>
        </div>

        <hr class="border-t border-dashed my-4">

        <p class="text-center">Terima Kasih</p>
        <p class="text-center">Selamat Belanja Kembali</p>

        <button class="btn-close mt-4 bg-red-500 text-white px-4 py-2 rounded-lg w-full">Tutup</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const modal = document.querySelector('.modal');
    const modalClose = document.querySelector('.btn-close');
    const detailButtons = document.querySelectorAll('.btn-detail');
    const modalContent = modal.querySelector('.modal-content');

    // Tutup modal
    modalClose.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Klik tombol detail
    detailButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const transaksiId = button.getAttribute('data-id');
            try {
                const response = await fetch(`/riwayat-user/${transaksiId}`);
                if (!response.ok) throw new Error('Gagal memuat data.');

                const data = await response.json();

                // Isi data ke modal
                modal.querySelector('p:nth-of-type(1)').innerText = `Email: ${data.user.email}`;
                modal.querySelector('p:nth-of-type(2)').innerText = `Tanggal: ${new Date(data.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                })}`;

                // Daftar produk
                const produkHtml = data.riwayat.map(riwayat => `
                    <tr>
                        <td class="px-2 py-1 text-left">${riwayat.produk}</td>
                        <td class="px-2 py-1 text-center">${riwayat.qty}</td>
                        <td class="px-2 py-1 text-right">Rp.${new Intl.NumberFormat('id-ID').format(riwayat.harga)}</td>
                        <td class="px-2 py-1 text-right">Rp.${new Intl.NumberFormat('id-ID').format(riwayat.subtotal)}</td>
                    </tr>
                `).join('');
                modal.querySelector('.modal-content .produk-list').innerHTML = produkHtml;

                // Total berdasarkan subtotal yang sudah dihitung di controller
                const total = data.riwayat.reduce((sum, item) => sum + item.subtotal, 0);
                modal.querySelector('.modal-content .total').innerText = `Rp.${new Intl.NumberFormat('id-ID').format(total)}`;

                // Tampilkan modal
                modal.classList.remove('hidden');
            } catch (error) {
                alert(error.message);
            }
        });
    });
});

    //trigger search form agar otomatis search tanpa perlu dienter terlebih dahulu
    document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('search-form');
            const searchInput = document.getElementById('default-search');

            // Trigger form submit di form input searchbar
            let timeout = null;
            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    form.submit(); // kirim form otomatis setelah 3 detik typing berenti
                }, 500); // delay 3 detik
            });
        });
</script>

@endsection