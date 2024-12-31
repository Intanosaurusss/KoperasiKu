@extends('components.layout-admin')

@section('title', 'Detail Pengeluaran')

@section('content')
<div class="pt-4 pl-2">
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="mb-4">
            <p class="font-medium text-gray-700">Tanggal Pengeluaran:</p>
            <p class="text-gray-700 text-sm">
                @php
                    use Carbon\Carbon;
                    Carbon::setLocale('id'); // Set locale ke Indonesia
                    // Memastikan format tanggal mengikuti waktu Indonesia
                    $tanggal = Carbon::parse($pengeluaran->tanggal_pengeluaran)->translatedFormat('d F Y');
                @endphp
                {{ $tanggal }}
            </p> 
        </div>
        <div class="mb-4">
            <p class="font-medium text-gray-700">Deskripsi:</p>
            <p class="text-gray-700 text-sm">{{ $pengeluaran->deskripsi_pengeluaran }}</p> 
        </div>
        <div>
            <p class="font-medium text-gray-700">Total Pengeluaran:</p>
            <p class="text-red-400 text-sm">Rp {{ number_format($pengeluaran->total_pengeluaran, 0, ',', '.') }}</p> 
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('cetakpengeluaranbyid.cetak', $pengeluaran->id) }}" class="bg-blue-400 hover:bg-blue-500 p-1 rounded-md flex items-center ml-auto text-white mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
            Cetak
        </a>
    </div>
</div>
@endsection
