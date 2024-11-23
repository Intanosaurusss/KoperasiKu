@extends('components.layout-admin')

@section('title', 'Member')

@section('content')
<div class="p-2">
    <div class="flex items-center p-4 mb-4 text-sm text-blue-700 rounded-lg bg-blue-100" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman member
        </div>
    </div>
    
<div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-sm">
    <!-- searchbar, dropddown dan button tambah member -->
<div class="flex flex-wrap items-center mt-4 w-full gap-4">
    <!-- Dropdown Kategori -->
    <div class="sm:order-1 order-2 sm:w-1/4 w-full max-w-xs">
        <select name="kategori_produk" id="kategori-dropdown" class="block w-full p-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:outline-none">
            <option value="">filter berdasarkan</option>
            <option value="pembelian tersering">pembelian tersering</option>
            <option value="total pembelian">total pembelian</option>
        </select>
    </div>

    <!-- Search Bar -->
    <form class="flex sm:order-2 order-1 items-center gap-4">
        <div class="flex items-center border border-gray-300 rounded-lg bg-white">
            <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
            <input type="search" name="search" id="default-search" class="block w-full p-2 pl-2 text-sm text-gray-900 border-0 rounded-lg focus:ring-blue-500 focus:outline-none" placeholder="Cari member..." required />
        </div>
    </form>

    <!-- Button Tambah Data Member -->
    <div class="flex gap-2 sm:order-3 order-3">
        <a href="{{ route('tambah-member.create') }}" method="GET">
            <button type="button" class="flex items-center bg-green-400 text-white hover:bg-green-500 focus:outline-none font-medium rounded-lg text-sm px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Tambah
            </button>
        </a>
        <a href="">
            <button type="button" class="flex items-center bg-green-400 text-white hover:bg-green-500 focus:outline-none font-medium rounded-lg text-sm px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Excel
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
                    <th class="px-2 py-2 font-semibold text-gray-700">Username</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">ID Member</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @foreach($members as $index => $member)
                <tr>
                    <td class="px-4 py-2 text-sm text-center text-gray-700">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $member->nama }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $member->id_member }}</td>
                    <td class="flex px-6 py-2 whitespace-nowrap text-sm text-gray-900 space-x-2 md:space-x-6 justify-center">
                        <div class="flex h-full w-full items-center justify-center space-x-2 md:space-x-6">
                            @include('components.crud-member')
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
</div>
@endsection
