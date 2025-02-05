@extends('components.layout-admin')

@section('title', 'Pengeluaran Admin')

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
    <form action="{{ route('pengeluaran-admin') }}" method="POST">
        @csrf
        <div class="space-y-5 m-4">
            <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Tambah Pengeluaran</h2>
            <div class="">
                <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">
                    <div class="col-span-full mt-1">
                        <label for="tanggal_pengeluaran" class="block font-medium leading-6 text-gray-700">Tanggal Pengeluaran</label>
                        <input type="date" id="tanggal_pengeluaran" name="tanggal_pengeluaran" class="block text-sm w-full py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md text-gray-600 @error('tanggal_pengeluaran') border-red-500 @enderror" max="{{ now()->toDateString() }}">
                        @error('tanggal_pengeluaran')
                            <p class="text-red-600 text-sm mt-1" id="tanggal_pengeluaran-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="total_pengeluaran" class="block font-medium leading-6 text-gray-700">Jumlah Pengeluaran</label>
                        <input type="number" id="total_pengeluaran" name="total_pengeluaran" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('total_pengeluaran') border-red-500 @enderror" placeholder="Silahkan isi jumlah pengeluaran" maxlength="9" oninput="limitDigits(this)">
                        @error('total_pengeluaran')
                            <p class="text-red-600 text-sm mt-1" id="total_pengeluaran-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="deskripsi_pengeluaran" class="block font-medium leading-6 text-gray-700">Deskripsi Pengeluaran</label>
                        <textarea id="deskripsi_pengeluaran" name="deskripsi_pengeluaran" rows="4" 
                            class="block w-full py-1.5 pl-2 text-sm text-gray-600 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400 @error('deskripsi_pengeluaran') border-red-500 @enderror" 
                            placeholder="Silahkan isi deskripsi pengeluaran"></textarea>
                        @error('deskripsi_pengeluaran')
                            <p class="text-red-600 text-sm mt-1" id="deskripsi_pengeluaran-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="{{ route('pages-admin.pengeluaran-admin') }}">
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
    const inputIds = ['tanggal_pengeluaran', 'total_pengeluaran','deskripsi_pengeluaran'];

    // Menambahkan event listener ke setiap input
    inputIds.forEach(id => {
        const inputElement = document.getElementById(id);
        if (inputElement) {
            inputElement.addEventListener('input', function() {
                removeErrorStyles(id);
            });
        }
    });

    // limit digit untuk menginput total_pengeluaran (9 digit angka)
    function limitDigits(input) {
    if (input.value.length > 9) {
        input.value = input.value.slice(0, 9);
    }
    }
</script>
@endsection
