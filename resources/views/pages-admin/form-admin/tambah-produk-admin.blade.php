@extends('components.layout-admin')

@section('title', 'Produk Admin')

@section('content')
<div class="pl-2">
    <div class="bg-white rounded-md shadow-md">
    <!-- @if ($errors->any())
        <div class="mb-4">
            <ul class="text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
     @endif -->
    <form action="{{ route('produk-admin') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="space-y-5 m-4">
        <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Tambah Produk</h2>
            <div class="">
                <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">

                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Nama produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('nama_produk') border-red-500 @enderror" placeholder="Silahkan isi nama produk">
                        @error('nama_produk')
                            <p class="text-red-600 text-sm mt-1" id="nama_produk-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Harga</label>
                        <input type="number" id="harga_produk" name="harga_produk" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('harga_produk') border-red-500 @enderror" placeholder="Silahkan isi harga produk" maxlength="7" oninput="limitDigitHarga(this)">
                        @error('harga_produk')
                            <p class="text-red-600 text-sm mt-1" id="harga_produk-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Stok</label>
                        <input type="number" id="stok_produk" name="stok_produk" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('stok_produk') border-red-500 @enderror" placeholder="Silahkan isi stok produk" maxlength="4" oninput="limitDigits(this)">
                        @error('stok_produk')
                            <p class="text-red-600 text-sm mt-1" id="stok_produk-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full mt-1">
                    <label for="kategori" class="block font-medium leading-6 text-gray-700">Kategori</label>
                    <select id="kategori_produk" name="kategori_produk" class="block w-full text-sm text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md @error('kategori_produk') border-red-500 @enderror">
                        <option value="" disabled selected class="text-gray-600">Pilih kategori produk</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="alat tulis kantor">Alat Tulis Kantor</option>
                        <option value="peralatan">Peralatan/Lainnya</option>
                    </select>
                    @error('kategori_produk')
                        <p class="text-red-600 text-sm mt-1" id="kategori_produk-error">{{ $message }}</p>
                    @enderror
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="foto_produk" class="block font-medium leading-6 text-gray-700">Foto Produk</label>
                        <label for="foto_produk" class="mt-1 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-2 cursor-pointer">
                            <div class="text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-1 flex items-center leading-6 text-gray-600 text-center">
                                    <span class="text-sm rounded-md bg-white font-semibold text-purple-500 hover:text-purple-600">
                                        Upload a file
                                    </span>  
                                    <p id="file-name" class="text-sm text-gray-600 ml-2"></p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600 text-center">PNG, JPG, JPEG maksimal 2MB</p>
                            </div>
                            <input id="foto_produk" name="foto_produk" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg">
                        </label> 
                        @error('foto_produk')
                            <p class="text-red-600 text-sm mt-1" id="foto_produk-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="{{ route('pages-admin.produk-admin') }}">
                    <button id="cancelbutton" type="button" class="px-2 py-1.5 bg-red-400 text-white rounded-md hover:bg-red-500 mb-6 transition ease-in-out duration-300">Batal</button>
                </a>
                <button id="submitbutton" type="submit" class="px-2 py-1.5 bg-purple-500 text-white rounded-md hover:bg-purple-600 mb-6 transition ease-in-out duration-300">Tambah</button>
            </div>
        </div>
    </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('foto_produk');
    const fileNameDisplay = document.getElementById('file-name');

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            fileNameDisplay.textContent = fileInput.files[0].name; // Menampilkan nama file
        } else {
            fileNameDisplay.textContent = ''; // Menghapus teks jika file dihapus
        }
    });

    // Fungsi untuk menghapus class error dan menyembunyikan pesan error
    function removeErrorStyles(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.classList.remove('border-red-500', 'focus:ring-red-500');
            const errorMessage = document.getElementById(inputId + '-error');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }
    }

    // Daftar ID input yang ingin dipantau
    const inputIds = ['nama_produk', 'harga_produk','stok_produk', 'kategori_produk', 'foto_produk'];

    // Menambahkan event listener ke setiap input
    inputIds.forEach(id => {
        const inputElement = document.getElementById(id);
        if (inputElement) {
            inputElement.addEventListener('input', function() {
                removeErrorStyles(id);
            });
        }
    });

    // limit digit untuk menginput stok_produk (18 digit angka)
    function limitDigits(input) {
    if (input.value.length > 4) {
        input.value = input.value.slice(0, 4);
    }
    }

    // limit digit untuk menginput harga_produk (18 digit angka)
    function limitDigitHarga(input) {
    if (input.value.length > 7) {
        input.value = input.value.slice(0, 7);
    }
    }
</script>
@endsection
