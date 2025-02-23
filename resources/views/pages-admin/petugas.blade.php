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
    <div id="flash-message" class="alert bg-red-100 text-red-700 text-sm border border-red-400 rounded p-1.5 mb-1.5">
        <strong class="font-bold">Kesalahan!</strong>
        <ul class="mt-2">
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="my-4">
        <!-- Profil dan status bertugas -->
        @if($petugasBertugas)
            <div class="flex items-center text-sm rounded-lg bg-green-200 px-2 py-2">
                <a href="" class="inline-block">
                    <img 
                        src="{{ $petugasBertugas->foto_profile ? asset('storage/' . $petugasBertugas->foto_profile) : asset('assets/default-profile.jpg') }}" 
                        alt="Profile {{ $petugasBertugas->nama }}" 
                        class="w-10 h-10 rounded-full object-cover"
                    />
                </a>
                <div class="ml-3">
                    <p class="font-medium text-green-800">{{ $petugasBertugas->nama }}</p>
                    <p class="text-sm text-green-800">sedang bertugas</p>
                </div>
            </div>
            @else
            <!-- Jika tidak ada petugas yang sedang bertugas -->
            <div class="flex items-center p-2.5 mb-4 text-sm text-red-700 rounded-lg bg-red-200 p-4" role="alert">
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

        <div class="flex flex-col md:flex-row items-center mt-4 w-full space-y-3 md:space-y-0 md:justify-end md:gap-2">
        <!-- Dropdown Kategori -->
        <form action="{{ route('cetakriwayatbypetugas') }}" method="POST" class="flex flex-wrap md:flex-nowrap items-center gap-2 w-full md:w-auto">
        @csrf
        <div class="sm:w-1/4 w-full max-w-xs md:w-auto">
            <select name="petugas_id" id="petugas_id" class="block w-full p-1.5 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:outline-none @error('petugas_id') border-red-500 @else border-gray-300 @enderror">
                <option value="">Filter Petugas</option>
                @foreach ($petugas as $p)
                    <option value="{{ $p->id }} ">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- input date awal dan akhir beserta tombol cetak -->
            <div class="flex items-center gap-1">
                <div class="flex flex-col">
                    <input type="date" name="date_start" class="border rounded-lg p-1.5 text-xs @error('date_start') border-red-500 @else border-gray-300 @enderror" placeholder="Tanggal Awal" max="{{ now()->toDateString() }}" />
                </div>
                <span class="mx-0.5">s.d.</span>
                <div class="flex flex-col">
                    <input type="date" name="date_end" class="border rounded-lg p-1.5 text-xs @error('date_end') border-red-500 @else border-gray-300 @enderror" placeholder="Tanggal Akhir" max="{{ now()->toDateString() }}" />
                </div>
            </div>

            <button type="submit" class="bg-blue-400 hover:bg-blue-500 p-1 rounded-md flex items-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span>Cetak</span>
            </button>
        </form>
        </div>

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

     // Menghilangkan pesan error input/validasi tanggal untuk mencetak riwayat setelah 5 detik
     document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            document.querySelectorAll("input.border-red-500, select.border-red-500").forEach(el => {
                el.classList.remove("border-red-500");
                el.classList.add("border-gray-300");
            });
        }, 3000);
    });
</script>
@endsection