@extends('components.layout-user')

@section('title', 'Saran')

@section('content')
<div class="p-2">
    <div class="flex items-center p-4 mb-4 text-sm text-purple-700 rounded-lg bg-purple-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman untuk memberikan saran kepada admin
        </div>
    </div>

    <!-- flash popup untuk menampilkan sukses/gagalnya menghapus produk dari keranjang -->
    @if (session('success'))
    <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Validasi Pesan -->
    @if ($errors->has('rating') || $errors->has('saran'))
    <div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">Silahkan isi rating/saran terlebih dahulu.</span>
    </div>
    @endif

    <form action="{{ route('saran.store') }}" method="POST">
        @csrf
        <div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-sm">
            <h2 class="font-medium leading-6 text-gray-700">Rating</h2>
            <div class="flex space-x-1">
                @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="hidden" {{ old('rating') == $i ? 'checked' : '' }} />
                    <label for="rating-{{ $i }}" class="cursor-pointer text-gray-400 hover:text-yellow-500">
                        ★
                    </label>
                @endfor
            </div>
            
            <div class="col-span-full mt-1">
                <label for="saran" class="block font-medium leading-6 text-gray-700">Saran</label>
                <textarea id="saran" name="saran" rows="4" class="block w-full py-1.5 pl-2 text-sm text-gray-600 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi saran untuk admin">{{ old('saran') }}</textarea>
            </div>
            
            <button type="submit" class="flex items-center space-x-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 mt-2 px-2 py-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-5 h-5" viewBox="0 0 50 50" fill="currentColor">
                    <path d="M46.137,6.552c-0.75-0.636-1.928-0.727-3.146-0.238l-0.002,0C41.708,6.828,6.728,21.832,5.304,22.445c-0.259,0.09-2.521,0.934-2.288,2.814c0.208,1.695,2.026,2.397,2.248,2.478l8.893,3.045c0.59,1.964,2.765,9.21,3.246,10.758c0.3,0.965,0.789,2.233,1.646,2.494c0.752,0.29,1.5,0.025,1.984-0.355l5.437-5.043l8.777,6.845l0.209,0.125c0.596,0.264,1.167,0.396,1.712,0.396c0.421,0,0.825-0.079,1.211-0.237c1.315-0.54,1.841-1.793,1.896-1.935l6.556-34.077C47.231,7.933,46.675,7.007,46.137,6.552z M22,32l-3,8l-3-10l23-17L22,32z"></path>
                </svg>
                <span id="submitbutton">Kirim</span>
            </button>
        </div>
    </form>
</div>

<script>
    // JavaScript untuk mengubah warna bintang saat diklik
    document.querySelectorAll('input[name="rating"]').forEach((radio) => {
        radio.addEventListener('change', (e) => {
            const rating = e.target.value;
            const labels = document.querySelectorAll('label');
            
            // Reset semua bintang menjadi abu-abu
            labels.forEach(label => label.classList.remove('text-yellow-500'));
            labels.forEach(label => label.classList.add('text-gray-400'));
            
            // Ubah warna bintang yang telah dipilih menjadi kuning
            for (let i = 0; i < rating; i++) {
                labels[i].classList.add('text-yellow-500');
            }
        });
    });
    
    //untuk mengatur flash message popup menghapus produk dari keranjang
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.remove();
            }, 3000); // Hapus pesan setelah 3 detik
        }
    });
</script>
@endsection
