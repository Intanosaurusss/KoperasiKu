@extends($layout)

@section('title', 'Profile' .' '. $user->name)

@section('content')
<div class="p-4 bg-white shadow-md rounded-md w-full max-w-screen-lg mx-auto mt-3">
    <div class="flex flex-col gap-8 md:flex-row items-center md:items-start">
        <!-- Foto Profil -->
        <img 
            src="{{ asset($user->foto_profile ?? 'images/default-profile.png') }}"  
            alt="Profile Image"
            class="bg-purple-400 w-24 h-24 md:w-32 md:h-32 rounded-full object-cover"
        />

        <!-- Data Diri User -->
        <div class="w-full space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500">Username</p>
                    <p class="font-medium text-gray-800 break-words">{{ $user->name }}</p>
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
                    <p class="text-gray-500">Password</p>
                    <p class="font-medium text-gray-800 break-words">••••••••</p> <!-- Password disembunyikan -->
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('pages.edit-profile', ['id' => $user->id]) }}">
        <div class="flex justify-end mt-4">
            <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Edit
            </button>
        </div>
    </a>
</div>
@endsection
