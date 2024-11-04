@extends('components.layout-admin')

@section('title', 'Detail Riwayat Pembelian By Date')

@section('content')
<div class="pt-4 pl-2">
<div class="p-4 bg-white rounded-lg shadow-md">
    <p class="font-bold text-gray-700 text-center">Detail Pembelian By Date</p>
    <p class="text-sm text-gray-700">28/10/24 - 29/10/24</p>
    <!-- Tabel Responsif -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-2 font-semibold text-gray-700">No</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">tanggal</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Email</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Total</th>
                    <th class="px-2 py-2 font-semibold text-gray-700">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-2 text-sm text-center text-gray-700">1</td>
                    <td class="px-4 py-2 text-sm text-gray-700">29/10/24</td>
                    <td class="px-4 py-2 text-sm text-gray-700">user@gmail.com</td>
                    <td class="px-4 py-2 text-sm text-gray-700">Rp. 4000</td>
                    <td class="px-4 py-2 text-sm text-gray-700">Teh pucuk 1x</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 text-sm text-center text-gray-700">1</td>
                    <td class="px-4 py-2 text-sm text-gray-700">30/10/24</td>
                    <td class="px-4 py-2 text-sm text-gray-700">user2@gmail.com</td>
                    <td class="px-4 py-2 text-sm text-gray-700">Rp. 2000</td>
                    <td class="px-4 py-2 text-sm text-gray-700">nabati 1x</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="text-sm text-gray-700 flex justify-end mt-4 font-semibold">Subtotal pembelian : Rp.6000</p>
</div>

</div>
@endsection
