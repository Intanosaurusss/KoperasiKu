@extends('components.layout-admin')

@section('title', 'Saran')

@section('content')
<div class="p-2">
    <div class="flex items-center p-4 mb-4 text-sm text-purple-700 rounded-lg bg-purple-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman saran dari user
        </div>
    </div>

    <!-- flash popup untuk menampilkan sukses/gagalnya menghapus produk dari keranjang -->
    @if (session('success'))
    <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-4">
    @foreach($saran as $item)
    <div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-md">
        <div class="flex items-center mt-1">
            <!-- Foto profil -->
            <a href="{{ route('profile', ['id' => $item->user_id]) }}" class="inline-block ml-4">
                <img 
                    src="{{ asset($item->user->foto_profile ? 'storage/' . $item->user->foto_profile : 'assets/default-profile.jpg') }}" 
                    alt="Profile Admin" 
                    class="w-12 h-12 rounded-full object-cover"
                />
            </a>

            <!-- Kontainer teks user -->
            <div class="ml-2 flex flex-col flex-grow">
                <p class="font-medium">{{ $item->user->nama }}</p>
                <p class="text-sm text-gray-600">{{ $item->user->kelas }}</p>
            </div>

            <!-- Tombol hapus -->
            <form action="{{ route('saran.destroy', $item->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="ml-auto text-red-500 hover:text-red-600 focus:outline-none" title="Hapus">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            </button>
            </form>

        </div>

        <!-- Rating dan saran -->
        <div class="mt-4">
            <h2 class="font-medium leading-6 text-gray-700">Rating</h2>
            <div class="text-lg flex items-center">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $item->rating) 
                        <!-- Bintang berwarna kuning jika rating tercapai -->
                        <span class="text-yellow-500">★</span>
                    @else
                        <!-- Bintang berwarna abu-abu untuk sisanya -->
                        <span class="text-gray-400">★</span>
                    @endif
                @endfor
            </div>
        </div>
    
        <div class="col-span-full mt-2">
            <label for="saran" class="block font-medium leading-6 text-gray-700">Saran</label>
            <textarea id="saran" name="saran" rows="3" class="block w-full py-1.5 pl-2 text-sm text-gray-600 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi deskripsi pengeluaran" readonly>{{ $item->saran }}</textarea>
        </div>

        <p class="text-right mt-1 text-xs text-gray-500">{{ $item->formatted_created_at }}</p>
    </div>
    @endforeach
    </div>
</div>

<script>
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
