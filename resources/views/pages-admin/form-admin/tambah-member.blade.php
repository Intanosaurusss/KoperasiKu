@extends('components.layout-admin')

@section('title', 'Member')

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
    <form action="{{ route('tambah-member') }}" method="POST">
        @csrf  <!-- token CSRF untuk keamanan-->
        <div class="space-y-5 m-4">
            <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Tambah Member</h2>
            <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">

                <div class="col-span-full mt-1">
                    <label for="nama" class="block font-medium leading-6 text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('nama') border-red-500 @enderror" placeholder="Silahkan isi Nama" value="{{ old('nama') }}">
                    @error('nama')
                        <p class="text-red-600 text-sm mt-1" id="nama-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-full mt-1">
                    <label for="email" class="block font-medium leading-6 text-gray-700">Email</label>
                    <input type="" id="email" name="email" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('email') border-red-500 @enderror" placeholder="Silahkan isi Email" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1" id="email-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-full mt-1">
                    <label for="kelas" class="block font-medium leading-6 text-gray-700">Kelas</label>
                    <input type="text" id="kelas" name="kelas" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('kelas') border-red-500 @enderror" placeholder="Silahkan isi Kelas" value="{{ old('kelas') }}">
                    @error('kelas')
                        <p class="text-red-600 text-sm mt-1" id="kelas-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-full mt-1">
                    <label for="no_telepon" class="block font-medium leading-6 text-gray-700">Nomor Telepon</label>
                    <input type="number" id="no_telepon" name="no_telepon" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('no_telepon') border-red-500 @enderror" placeholder="Silahkan isi Nomor Telepon" value="{{ old('no_telepon') }}"  maxlength="13" oninput="limitDigitsNoTelepon(this)">
                    @error('no_telepon')
                        <p class="text-red-600 text-sm mt-1" id="no_telepon-error">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="{{ route('pages-admin.member') }}">
                    <button id="cancelbutton" type="button" class="px-2 py-1.5 bg-red-400 text-white rounded-md hover:bg-red-500 mb-6 transition ease-in-out duration-300">Batal</button>
                </a>
                <button id="submitbutton" type="submit" class="px-2 py-1.5 bg-purple-500 text-white rounded-md hover:bg-purple-600 mb-6 transition ease-in-out duration-300">Tambah</button>
            </div>
        </div>
    </form>
    </div>
</div>

<script>
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
    const inputIds = ['nama', 'id_member','kelas', 'email', 'no_telepon'];

    // Menambahkan event listener ke setiap input
    inputIds.forEach(id => {
        const inputElement = document.getElementById(id);
        if (inputElement) {
            inputElement.addEventListener('input', function() {
                removeErrorStyles(id);
            });
        }
    });

    // limit digit untuk menginput id_member (18 digit angka)
    function limitDigitsIdMember(input) {
    if (input.value.length > 18) {
        input.value = input.value.slice(0, 18);
        }
    }

    // limit digit untuk menginput no_telepon (13 digit angka)
    function limitDigitsNoTelepon(input) {
    if (input.value.length > 13) {
        input.value = input.value.slice(0, 13);
        }
    }
</script>
@endsection
