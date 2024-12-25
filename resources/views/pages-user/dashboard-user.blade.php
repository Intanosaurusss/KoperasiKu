@extends('components.layout-user')

@section('title', 'Dashboard')

@section('content')
<div class="p-2">
    <!-- Konten dashboard pengguna Anda di sini -->
    <h2 class="text-xl font-semibold text-gray-700">Selamat datang {{ Auth::user()->nama }}, kamu mau beli apa?</h2>

    <!-- Dropdown dengan Search Bar -->
    <div class="flex flex-col sm:flex-row items-center mt-4 w-full">
        <form method="GET" action="{{ route('pages-user.dashboard-user') }}" id="search-form" class="w-full">
            <div class="flex flex-col sm:flex-row items-stretch gap-2">
                <!-- Dropdown Kategori -->
                <div class="sm:w-1/4 w-full max-w-xs">
                    <select name="kategori_produk" id="kategori-dropdown" class="block w-full p-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:outline-none">
                        <option value="">Filter Kategori</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="alat tulis kantor">Alat Tulis Kantor</option>
                        <option value="peralatan">Peralatan/Lainnya</option>
                        <option value="produk terlaris">Produk Terlaris</option>
                    </select>
                </div>

                <!-- Search Input -->
                <div class="flex-1 max-w-xs">
                    <div class="flex items-center border border-gray-300 rounded-lg bg-white w-full">
                        <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <input 
                            type="search" 
                            name="search" 
                            id="default-search" 
                            class="block w-full p-2 pl-2 text-sm text-gray-900 border-0 rounded-lg focus:ring-blue-500 focus:outline-none" 
                            placeholder="Cari produk..." />
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- popup pesan jika produk akan dimasukkan ke keranjang -->
    @if (session('success'))
        <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-4" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('warning'))
        <div id="flash-message" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded my-4" role="alert">
            <strong class="font-bold">Peringatan!</strong>
            <span class="block sm:inline">{{ session('warning') }}</span>
        </div>
    @endif

    <!-- pembungkus kontainer semua card produk -->
    <div class="mt-6 mx-3 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-5 xl:gap-x-8">
    
    @if($produk->isEmpty())
        <!-- Tampilkan pesan jika tidak ada data setelah pencarian -->
        <tr>
            <td colspan="5" class="px-4 py-2 text-center text-gray-700">
                Data tidak ditemukan
            </td>
        </tr>
        @else
    <!-- card 1 -->
    @foreach ($produk as $produk)
    <div class="group shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('storage/' . $produk->foto_produk) }}" alt="foto produk" class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="#">
                {{ $produk->nama_produk }}
                </a>
            </h3>
            <p class="mt-1 mb-1 text-sm text-gray-400">stok : {{ $produk->stok_produk }}</p>
            <div class="flex justify-between items-center">
            <p class="font-semibold text-red-400 mr-2 mb-3">Rp. {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
            <form action="{{ route('tambah-ke-keranjang') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="number" name="qty" value="1" min="1" class="hidden">
                <button type="submit" class="text-sm text-white bg-purple-400 px-1.5 py-1.5 mr-2 mb-3 rounded-md tracking-wide disabled:bg-gray-400 disabled:cursor-not-allowed" {{ $produk->stok_produk == 0 ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                    </svg>
                </button>
            </form>
            </div>
        </div>
    </div>
    </div>
    @endforeach 
    @endif

<!-- penutup kontainer pembungkus semua card -->
</div>

<script>
    // Menghilangkan popup pesan flash selama 3 detik saat produk dimasukkan ke keranjang
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.remove();
        }
    }, 3000); // 3000 ms = 3 detik

    // Mengirim form search (di bagian searchbar/dropdown) secara otomatis tanpa mengklik button cari/enter
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('search-form');
        const kategoriDropdown = document.getElementById('kategori-dropdown');
        const searchInput = document.getElementById('default-search');

        // Trigger form submit when dropdown value changes
        kategoriDropdown.addEventListener('change', function () {
            form.submit();
        });

        // Trigger form submit on input in search bar (debounced to avoid excessive submits)
        let timeout = null;
        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit();
            }, 2000); // Delay 2 detik
        });
    });

</script>
</div>
@endsection
