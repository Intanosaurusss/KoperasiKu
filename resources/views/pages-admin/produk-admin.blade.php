@extends('components.layout-admin')

@section('title', 'Produk Admin')

@section('content')
<div class="p-2">
    <div class="flex items-center p-4 mb-4 text-sm text-purple-700 rounded-lg bg-purple-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
    <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman produk yang akan dijual
        </div>
    </div>

    <div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-sm">
    <!-- searchbar -->
    <div class="flex items-center mt-4 w-full">
    <form method="GET" action="{{ route('pages-admin.produk-admin') }}"  id="search-form">
        <div class="flex items-center border border-gray-300 rounded-lg bg-white">
            <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
            <input type="search" name="search" id="default-search" class="block w-full p-2 pl-2 text-sm text-gray-900 border-0 rounded-lg focus:ring-blue-500 focus:outline-none" placeholder="Cari produk..." required />
        </div>
    </form>
    <!-- button tambah data produk -->
    <div class="flex ml-2">
        <a href="{{ route('tambah-produk-admin') }}">
        <button type="button" class="flex items-center bg-green-400 text-white hover:bg-green-500 focus:outline-none font-medium rounded-lg text-sm px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
            </svg>
            Tambah
        </button>
        </a>
    </div>
    </div>

    <!-- Tabel Responsif -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-2 font-semibold text-gray-700">No</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Nama produk</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Harga</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Stok</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @if($produk->isEmpty())
            <!-- Tampilkan pesan jika tidak ada data setelah pencarian -->
            <tr>
                <td colspan="5" class="px-4 py-2 text-center text-gray-700">
                    Data tidak ditemukan
                </td>
            </tr>
            @else
            @foreach ($produk as $index => $item)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 text-sm text-center text-gray-700">{{ ($produk->currentPage() - 1) * $produk->perPage() + $loop->iteration }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                    <div class="flex flex-col items-center md:flex-row md:space-x-2">
                        <img 
                            src="{{ asset($item->foto_produk) }}" 
                            alt="{{ $item->nama_produk }}" 
                            class="w-16 h-16 cursor-pointer rounded"
                            onclick="openModal()" 
                        />
                        <span class="mt-2 md:mt-0">{{ $item->nama_produk }}</span>
                    </div>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">Rp. {{ $item->harga_produk }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item->stok_produk }}</td>
                    <td class="p-4 text-sm text-gray-900">
                        <div class="flex h-full w-full items-center justify-center space-x-2 md:space-x-6">
                            @include('components.crud-produk-admin')
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
  </div>
  
<!-- Pagination -->
<div class="mt-4 flex justify-end space-x-2">
        <!-- Tombol Previous -->
        @if ($produk->onFirstPage())
            <span class="px-3 py-1 bg-gray-300 text-gray-500 text-sm rounded cursor-default">
                Previous
            </span>
        @else
            <a href="{{ $produk->previousPageUrl() }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">
                Previous
            </a>
        @endif
        <!-- Tombol Halaman Dinamis -->
        @php
            $currentPage = $produk->currentPage();
            $lastPage = $produk->lastPage();

            // Tentukan dua tombol nomor halaman secara dinamis
            $start = max(1, $currentPage - 1);
            $end = min($lastPage, $currentPage + 1);
        @endphp
        <!-- Tampilkan dua tombol halaman yang sesuai -->
        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $currentPage)
                <span class="px-3 py-1 bg-blue-500 text-white text-sm rounded">{{ $page }}</span>
            @else
                <a href="{{ $produk->url($page) }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
            @endif
        @endfor
        <!-- Tombol Next -->
        @if ($produk->hasMorePages())
            <a href="{{ $produk->nextPageUrl() }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">
                Next
            </a>
        @else
            <span class="px-3 py-1 bg-gray-300 text-gray-500 text-sm rounded cursor-default">
                Next
            </span>
        @endif
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('search-form');
        const searchInput = document.getElementById('default-search');

        // Trigger form submit on input in search bar (debounced to avoid excessive submits)
        let timeout = null;
        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit(); // Submit form automatically after 3 seconds of no typing
            }, 500); // Delay for 3 seconds
        });
    });
</script>

@endsection