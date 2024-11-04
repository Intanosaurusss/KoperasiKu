@extends('components.layout-admin')

@section('title', 'Pengeluaran Admin')

@section('content')
<div class="pl-2">
    <div class="bg-white rounded-md shadow-md">
    <form>
        <div class="space-y-5 m-4">
        <h2 class="text-xl font-semibold text-gray-700 pt-4 text-center">Edit Pengeluaran</h2>
            <div class="">
                <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-2 md:grid-cols-2">
                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Tanggal Pengeluaran</label>
                        <input type="date" id="" class="block text-sm w-full py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md text-gray-600">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="" class="block font-medium leading-6 text-gray-700">Jumlah Pengeluaran</label>
                        <input type="text" id="" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi jumlah pengeluaran">
                    </div>

                    <div class="col-span-full mt-1">
                        <label for="detail-pengeluaran" class="block font-medium leading-6 text-gray-700">Detail Pengeluaran</label>
                        <textarea id="detail-pengeluaran" rows="4" 
                            class="block w-full py-1.5 pl-2 text-sm text-gray-600 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md placeholder:text-gray-400" 
                            placeholder="Silahkan isi detail pengeluaran"></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-6 mb-10 flex justify-end gap-x-6">
                <a href="pengeluaran-admin">
                    <button id="cancelbutton" type="button" class="px-2 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-400 focus:ring focus:ring-red-300 mb-6">Batal</button>
                </a>
                <button id="submitbutton" type="button" class="px-2 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:ring focus:ring-blue-300 mb-6">Edit</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection
