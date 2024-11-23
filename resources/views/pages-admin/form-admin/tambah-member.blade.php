@extends('components.layout-admin')

@section('title', 'Member')

@section('content')
<div class="pl-2">
    <div class="bg-white rounded-md shadow-md">
    @if ($errors->any())
        <div class="mb-4">
            <ul class="text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
     @endif
    <form action="{{ route('tambah-member') }}" method="POST">
        @csrf  <!-- CSRF token for security -->
        <div class="space-y-5 m-4">
            <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Tambah Member</h2>
            <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">

                <div class="col-span-full mt-1">
                    <label for="nama" class="block font-medium leading-6 text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi Nama" value="{{ old('nama') }}">
                </div>

                <div class="col-span-full mt-1">
                    <label for="id_member" class="block font-medium leading-6 text-gray-700">ID Member</label>
                    <input type="number" id="id_member" name="id_member" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi ID Member" value="{{ old('id_member') }}">
                </div>

                <div class="col-span-full mt-1">
                    <label for="email" class="block font-medium leading-6 text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi Email" value="{{ old('email') }}">
                </div>

                <div class="col-span-full mt-1">
                    <label for="kelas" class="block font-medium leading-6 text-gray-700">Kelas</label>
                    <input type="text" id="kelas" name="kelas" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi Kelas" value="{{ old('kelas') }}">
                </div>

                <div class="col-span-full mt-1">
                    <label for="no_telepon" class="block font-medium leading-6 text-gray-700">Nomor Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi Nomor Telepon" value="{{ old('no_telepon') }}">
                </div>

            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="{{ route('pages-admin.member') }}">
                    <button id="cancelbutton" type="button" class="px-2 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-400 focus:ring focus:ring-red-300 mb-6">Batal</button>
                </a>
                <button id="submitbutton" type="submit" class="px-2 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:ring focus:ring-blue-300 mb-6">Tambah</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection
