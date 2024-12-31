@extends($layout)

@section('title', 'Profile' .' '. $user->nama)

@section('content')
<div class="p-4 bg-white shadow-md rounded-md w-full max-w-screen-lg mx-auto mt-3">
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

    <div class="flex flex-col gap-8 md:flex-row items-center md:items-start">
        <!-- Foto Profil -->
        
        <img 
            src="{{ asset($user->foto_profile ? 'storage/' . $user->foto_profile : 'assets/default-profile.jpg') }}"
            alt="Profile Image"
            class="bg-purple-400 w-24 h-24 md:w-32 md:h-32 rounded-full object-cover"
        />

        <!-- Data Diri User -->
        <div class="w-full space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500">Username</p>
                    <p class="font-medium text-gray-800 break-words">{{ $user->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Kelas</p>
                    <p class="font-medium text-gray-800 break-words">{{ $user->kelas ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">No Telepon</p>
                    <p class="font-medium text-gray-800 break-words">{{ $user->no_telepon }}</p>
                </div>
                <div> 
                    <p class="text-gray-500">Email</p>
                    <p class="font-medium text-gray-800 break-words">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500">ID Member</p>
                    <p class="font-medium text-gray-800 break-words">{{ $user->id_member }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-4 gap-4">
    <a href="{{ route('pages.edit-profile', ['id' => $user->id]) }}">
        <div class="flex justify-end mt-4">
            <button class="px-2 py-2 bg-purple-400 text-white rounded-md hover:bg-purple-500 transition ease-in-out duration-300">
                Edit Profil
            </button>
        </div>
    </a>
    </div>

</div>

<script>
    // Menghilangkan popup pesan flash selama 3 detik saat produk dimasukkan ke keranjang
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.remove();
        }
    }, 3000); // 3000 ms = 3 detik
</script>
@endsection
