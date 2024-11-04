@extends('components.layout-admin')

@section('title', 'Detail Riwayat Pembelian')

@section('content')
<div class="pt-4 pl-2">
<div class="p-4 bg-white rounded-lg shadow-md">
    <p class="font-bold text-gray-700 text-center">Detail Pembelian</p>
    <p class="text-sm text-gray-700">28/10/24</p>
    <!-- Tabel Responsif -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-2 font-semibold text-gray-700">No</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Email</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Produk</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Harga</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-2 text-sm text-center text-gray-700">1</td>
                    <td class="px-4 py-2 text-sm text-gray-700">user@gmail.com</td>
                    <td class="px-4 py-2 text-sm text-gray-700">2x nabati coklat</td>
                    <td class="px-4 py-2 text-sm text-gray-700">Rp. 2000</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="text-sm text-gray-700 flex justify-end mt-4 font-semibold">Subtotal pembelian : Rp.4000</p>
</div>
    <button class="bg-indigo-600 p-1 rounded-md flex items-center ml-auto text-white mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
        </svg>
        Cetak
    </button>
</div>
@endsection
