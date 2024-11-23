@extends($layout)

@section('title', 'Profile' .' '. $user->name)

@section('content')
<div class="pl-2">
    <div class="bg-white rounded-md shadow-md">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        <div class="space-y-5 m-4">
        @csrf
        @method('PUT')
        <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Edit Profile</h2>
            <div class="">
                <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">

                    <div class="col-span-full mt-1">
                        <label for="nama" class="block font-medium leading-6 text-gray-700">Username</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi username">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="kelas" class="block font-medium leading-6 text-gray-700">Kelas</label>
                        <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $user->kelas) }}" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi kelas">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="no_telepon" class="block font-medium leading-6 text-gray-700">No telepon</label>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi nomor telepon">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="email" class="block font-medium leading-6 text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi email">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="id_member" class="block font-medium leading-6 text-gray-700">ID Member</label>
                        <input type="number" id="id_member" name="id_member" value="{{ old('id_member', $user->id_member) }}" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi id member">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="foto_profile" class="block font-medium leading-6 text-gray-700">Foto</label>
                        <div class="mt-1 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-6">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex leading-6 text-gray-600">
                                    <label for="foto_profile" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="foto_profile" name="foto_profile" type="file" class="sr-only" accept="image/png, image/jpeg, image/gif">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="{{ route('profile', ['id' => Auth::id()]) }}">
                    <button id="cancelbutton" type="button" class="px-2 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-400 focus:ring focus:ring-red-300 mb-6">Batal</button>
                </a>
                <button id="submitbutton" type="submit" class="px-2 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:ring focus:ring-blue-300 mb-6">Edit</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection
