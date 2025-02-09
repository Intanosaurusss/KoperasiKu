@extends('components.layout-admin')

@section('title', 'Petugas')

@section('content')
<div class="p-2">
    <div class="flex items-center p-4 mb-4 text-sm text-purple-700 rounded-lg bg-purple-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman petugas
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
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 mb-2" role="alert" id="flash-message">
        <strong class="font-bold">Terjadi kesalahan saat mengimpor data!</strong>
        <ul class="mt-2">
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<!-- container utama konten -->
<div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-sm md:flex-row justify-between items-center">
    <!-- container button tambah, filter, tanggal dan cetak -->
    <div class="flex flex-col md:flex-row items-center mt-3 w-full space-y-3 md:space-y-0 md:space-x-4">
        <!-- Tombol Tambah di sebelah kiri -->
        <div class="md:mb-0 self-center">
            <a href="{{ $jumlahPetugas < 5 ? route('tambah-petugas.create') : '#' }}" method="GET">
                <button type="button" 
                    class="flex items-center bg-green-400 text-white hover:bg-green-500 focus:outline-none font-medium rounded-lg text-sm px-4 py-2 disabled:opacity-75 disabled:cursor-not-allowed disabled:hover:bg-green-400"
                    @if($jumlahPetugas >= 5) disabled @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                    Tambah
                </button>
            </a>
        </div>

        <!-- Profil dan status bertugas -->
        @if($petugasBertugas)
            <div class="flex items-center">
                <a href="" class="inline-block">
                    <img 
                        src="{{ $petugasBertugas->foto_profile ? asset('storage/' . $petugasBertugas->foto_profile) : asset('assets/default-profile.jpg') }}" 
                        alt="Profile {{ $petugasBertugas->nama }}" 
                        class="w-12 h-12 rounded-full object-cover"
                    />
                </a>
                <div class="ml-3">
                    <p class="font-medium">{{ $petugasBertugas->nama }}</p>
                    <p class="text-sm text-gray-600">sedang bertugas</p>
                </div>
            </div>
            @else
            <!-- Jika tidak ada petugas yang sedang bertugas -->
            <div class="flex items-center p-2.5 mb-4 text-sm text-red-700 rounded-lg bg-red-200" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Info!</span> Tidak ada petugas yang sedang bertugas
                </div>
            </div>
        @endif

    </div>
    <!-- akhir container button tambah, dan elemen profile petugas yang sedang login -->

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
                @if($petugas->isEmpty())
                <!-- Tampilkan pesan jika tidak ada data petugas -->
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center text-gray-700">
                        Data tidak ditemukan
                    </td>
                </tr>
                @else
                @foreach($petugas as $index => $petugas)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 text-sm text-center text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $petugas->nama }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $petugas->id_member }}</td>
                        <td class="flex px-6 py-2 whitespace-nowrap text-sm text-gray-900 space-x-2 md:space-x-6 justify-center">
                            <div class="flex h-full w-full items-center justify-center space-x-2 md:space-x-6">
                                @include('components.crud-petugas')
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

<!-- penutup kontainer utama konten-->
</div>

</div>

<script>
    // Menghilangkan popup pesan flash selama 3 detik
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.remove();
        }
    }, 3000); // 3000 ms = 3 detik
</script>
@endsection