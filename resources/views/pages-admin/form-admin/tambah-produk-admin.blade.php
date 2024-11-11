@extends('components.layout-admin')

@section('title', 'Produk Admin')

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
    <form action="{{ route('produk-admin') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="space-y-5 m-4">
        <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Tambah Produk</h2>
            <div class="">
                <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">

                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Nama produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi nama produk">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Harga</label>
                        <input type="text" id="harga_produk" name="harga_produk" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi harga produk">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Stok</label>
                        <input type="text" id="stok_produk" name="stok_produk" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi stok produk">
                    </div>

                    <div class="col-span-full mt-1">
                    <label for="kategori" class="block font-medium leading-6 text-gray-700">Kategori</label>
                    <select id="kategori_produk" name="kategori_produk" class="block w-full text-sm text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md">
                        <option value="" disabled selected class="text-gray-600">Pilih kategori produk</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="peralatan">Peralatan/Lainnya</option>
                    </select>
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="foto_produk" class="block font-medium leading-6 text-gray-700">Foto Produk</label>
                        <div class="mt-1 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-6">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex leading-6 text-gray-600">
                                    <label for="foto_produk" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="foto_produk" name="foto_produk" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="">
                    <button id="cancelbutton" type="button" class="px-2 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-400 focus:ring focus:ring-red-300 mb-6">Batal</button>
                </a>
                <button id="submitbutton" type="submit" class="px-2 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:ring focus:ring-blue-300 mb-6">Tambah</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection
