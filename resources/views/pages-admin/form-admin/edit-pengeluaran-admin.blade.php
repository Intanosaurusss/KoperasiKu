@extends('components.layout-admin')

@section('title', 'Pengeluaran Admin')

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
    <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="space-y-5 m-4">
        <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Edit Pengeluaran</h2>
            <div class="">
                <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">
                    <div class="col-span-full mt-1">
                        <label for="tanggal_pengeluaran" class="block font-medium leading-6 text-gray-700">Tanggal Pengeluaran</label>
                        <input type="date" id="tanggal_pengeluaran" name="tanggal_pengeluaran" class="block text-sm w-full py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md text-gray-600" value="{{ $pengeluaran->tanggal_pengeluaran }}">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="total_pengeluaran" class="block font-medium leading-6 text-gray-700">Jumlah Pengeluaran</label>
                        <input type="text" id="total_pengeluaran" name="total_pengeluaran" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi jumlah pengeluaran" value="{{ $pengeluaran->total_pengeluaran }}">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="deskripsi_pengeluaran" class="block font-medium leading-6 text-gray-700">Deskripsi Pengeluaran</label>
                        <textarea id="deskripsi_pengeluaran" rows="4"  name="deskripsi_pengeluaran" class="block w-full py-1.5 pl-2 text-sm text-gray-600 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi detail pengeluaran" value="{{ $pengeluaran->deskripsi_pengeluaran }}">{{ $pengeluaran->deskripsi_pengeluaran }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="{{ route('pages-admin.pengeluaran-admin') }}">
                    <button id="cancelbutton" type="button" class="px-2 py-1.5 bg-red-400 text-white rounded-md hover:bg-red-500 mb-6 transition ease-in-out duration-300">Batal</button>
                </a>
                <button id="submitbutton" type="submit" class="px-2 py-1.5 bg-purple-500 text-white rounded-md hover:bg-purple-600 mb-6 transition ease-in-out duration-300">Edit</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection
