@extends('components.layout-admin')

@section('title', 'Detail Member')

@section('content')
<div class="bg-white pt-1 px-2 pb-2 rounded-md shadow-md">
    <p class="text-center font-semibold text-gray-700 my-3">Detail Member</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
        <div>
            <p class="text-gray-500">Username</p>
            <p class="font-medium text-gray-800">{{ $member->nama }}</p>
        </div>
        <div>
            <p class="text-gray-500">ID Member :</p>
            <p class="font-medium text-gray-800">{{ $member->id_member }}</p>
        </div>
        <div>
            <p class="text-gray-500">Email :</p>
            <p class="font-medium text-gray-800">{{ $member->email }}</p>
        </div>
        <div>
            <p class="text-gray-500">Kelas</p>
            <p class="font-medium text-gray-800">{{ $member->kelas }}</p>
        </div>
        <div>
            <p class="text-gray-500">Nomor Telepon :</p>
            <p class="font-medium text-gray-800">{{ $member->no_telepon }}</p>
        </div>
    </div>
</div>
@endsection
