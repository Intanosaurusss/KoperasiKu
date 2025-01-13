@extends('components.layout-admin')

@section('title', 'Member')

@section('content')
<div class="p-2">
    <div class="flex items-center p-4 mb-4 text-sm text-purple-700 rounded-lg bg-purple-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman member
        </div>
    </div>
    
    <!-- popup pesan sukses/gagal respon dari backend -->
    @if(session('success'))
        <div id="flash-message" class="alert bg-green-100 text-green-700 text-sm border border-green-400 rounded p-2 mb-2">
        <strong class="font-bold">Sukses!</strong>
        {{ session('success') }}
        </div>
        @endif
    @if(session('error'))
        <div id="flash-message" class="alert bg-red-100 text-red-700 text-sm border border-red-400 rounded p-2 mb-2">
        <strong class="font-bold">Gagal!</strong>
        {{ session('error') }}
        </div>
    @endif

<div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-sm">
    <!-- Searchbar dan Button Tambah Member -->
    <div class="flex flex-col md:flex-row items-center md:space-x-4 mt-4 w-full">
        <!-- Search Bar dan Tombol -->
        <div class="flex flex-col md:flex-row items-center w-full md:w-auto space-y-2 md:space-y-0 md:space-x-2">
            <!-- Search Bar -->
            <form id="search-form" action="{{ route('pages-admin.member') }}" method="GET" class="w-full md:w-auto">
                <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                    <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <input type="search" name="search" id="default-search" 
                        class="block w-full p-2 pl-2 text-sm text-gray-900 border-0 rounded-lg focus:ring-blue-500 focus:outline-none" 
                        placeholder="Cari member..." value="{{ request('search') }}" />
                </div>
            </form>

            <!-- Button Tambah Data Member -->
            <div class="flex space-x-2">
                <a href="{{ route('tambah-member.create') }}" method="GET">
                    <button type="button" class="flex items-center bg-green-400 text-white hover:bg-green-500 focus:outline-none font-medium rounded-lg text-sm px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                        </svg>
                        Tambah
                    </button>
                </a>

                <form action="{{ route('import-excel.member') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button type="button" id="importExcelBtn" class="flex items-center bg-green-400 text-white hover:bg-green-500 focus:outline-none font-medium rounded-lg text-sm px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                        </svg>
                        Excel
                    </button>
                    <input type="file" name="file" class="hidden" accept=".xlsx,.xls" id="fileInput" />
                    <button type="submit" class="hidden" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Responsif -->
    <div class="overflow-x-auto mt-4">
    <div class="min-w-full w-64">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-2 font-semibold text-gray-700">No</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Username</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">ID Member</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @if($members->isEmpty())
            <!-- Tampilkan pesan jika tidak ada data setelah pencarian -->
            <tr>
                <td colspan="5" class="px-4 py-2 text-center text-gray-700">
                    Data tidak ditemukan
                </td>
            </tr>
            @else
            @foreach($members as $index => $member)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 text-sm text-center text-gray-700">{{ ($members->currentPage() - 1) * $members->perPage() + $index + 1 }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $member->nama }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $member->id_member }}</td>
                    <td class="flex px-6 py-2 whitespace-nowrap text-sm text-gray-900 space-x-2 md:space-x-6 justify-center">
                        <div class="flex h-full w-full items-center justify-center space-x-2 md:space-x-6">
                            @include('components.crud-member')
                        </div>
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
    @if ($members->onFirstPage())
        <span class="px-3 py-1 bg-gray-300 text-gray-500 text-sm rounded cursor-default">
            Previous
        </span>
    @else
        <a href="{{ $members->previousPageUrl() }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">
            Previous
        </a>
    @endif

    @php
        $currentPage = $members->currentPage();
        $lastPage = $members->lastPage();
        $start = max(1, $currentPage - 1);
        $end = min($lastPage, $currentPage + 1);
        @endphp

        @for ($page = $start; $page <= $end; $page++)
        @if ($page == $currentPage)
            <span class="px-3 py-1 bg-purple-500 text-white text-sm rounded">{{ $page }}</span>
        @else
            <a href="{{ $members->url($page) }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
        @endif
        @endfor

        @if ($members->hasMorePages())
            <a href="{{ $members->nextPageUrl() }}" class="px-3 py-1 bg-white text-gray-700 text-sm rounded border border-gray-300 hover:bg-gray-100">
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
    // Menangani klik tombol untuk membuka dialog pemilihan file (button tambah excel)
    document.getElementById('importExcelBtn').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    // Jika file dipilih, otomatis submit form
    document.getElementById('fileInput').addEventListener('change', function() {
        if (this.files.length > 0) {
            document.getElementById('submitBtn').click(); // Submit form
        }
    });

    // Menghilangkan popup pesan flash selama 3 detik saat produk dimasukkan ke keranjang
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.remove();
        }
    }, 3000); // 3000 ms = 3 detik

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('search-form');
        const searchInput = document.getElementById('default-search');

        // Trigger form submit on input in search bar (debounced to avoid excessive submits)
        let timeout = null;
        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit(); // Submit form automatically after 3 seconds of no typing
            }, 3000); // Delay 3 detik
        });
    });
</script>
@endsection
