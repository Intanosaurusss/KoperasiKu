@extends('components.layout-user')

@section('title', 'Dashboard User')

@section('content')
<div class="p-2">
    <!-- Konten dashboard pengguna Anda di sini -->
    <h2 class="text-xl font-semibold text-gray-700">Selamat datang User, hari ini mau jajan apa?</h2>

    <!-- searchbar -->
    <div class="flex items-center mt-4 w-full">
        <form>
            <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                <svg class="w-4 h-4 text-gray-500 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <input type="" id="default-search" class="block w-full p-2 pl-2 text-sm text-gray-900 border-0 rounded-lg focus:ring-blue-500 focus:outline-none" placeholder="Cari produk..." required />
            </div>
        </form>
    </div>

    <!-- pembungkus kontainer semua card produk -->
    <div class="mt-6 mx-3 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-5 xl:gap-x-8">

    <!-- card 1 -->
    <div class="group shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('assets/shop.jpg') }}" alt="Front of men&#039;s Basic Tee in black." class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="#">
                   Nabati
                </a>
            </h3>
            <p class="mt-1 mb-1 text-sm text-gray-400">Stok : 1</p>
            <div class="flex justify-between items-center">
            <p class="font-semibold text-red-400 mr-2 mb-3">Rp 2.000</p>
            <button class="text-sm text-white bg-purple-400 px-1.5 py-1.5 mr-2 mb-3 rounded-md tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                </svg>
            </button>
            </div>
        </div>
    </div>
    </div>

    <!-- card 2 -->
    <div class="group shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('assets/shop.jpg') }}" alt="Front of men&#039;s Basic Tee in black." class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="#">
                   Nabati
                </a>
            </h3>
            <p class="mt-1 mb-1 text-sm text-gray-400">Stok : 1</p>
            <div class="flex justify-between items-center">
            <p class="font-semibold text-red-400 mr-2 mb-3">Rp 2.000</p>
            <button class="text-sm text-white bg-purple-400 px-1.5 py-1.5 mr-2 mb-3 rounded-md tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                </svg>
            </button>
            </div>
        </div>
    </div>
    </div>

    <!-- card 3 -->
    <div class="group shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('assets/shop.jpg') }}" alt="Front of men&#039;s Basic Tee in black." class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="#">
                   Nabati
                </a>
            </h3>
            <p class="mt-1 mb-1 text-sm text-gray-400">Stok : 1</p>
            <div class="flex justify-between items-center">
            <p class="font-semibold text-red-400 mr-2 mb-3">Rp 2.000</p>
            <button class="text-sm text-white bg-purple-400 px-1.5 py-1.5 mr-2 mb-3 rounded-md tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                </svg>
            </button>
            </div>
        </div>
    </div>
    </div>

    <!-- card 4 -->
    <div class="group shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('assets/shop.jpg') }}" alt="Front of men&#039;s Basic Tee in black." class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="#">
                   Nabati
                </a>
            </h3>
            <p class="mt-1 mb-1 text-sm text-gray-400">Stok : 1</p>
            <div class="flex justify-between items-center">
            <p class="font-semibold text-red-400 mr-2 mb-3">Rp 2.000</p>
            <button class="text-sm text-white bg-purple-400 px-1.5 py-1.5 mr-2 mb-3 rounded-md tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                </svg>
            </button>
            </div>
        </div>
    </div>
    </div>

    <!-- card 5 -->
    <div class="group shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('assets/shop.jpg') }}" alt="Front of men&#039;s Basic Tee in black." class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="#">
                   Nabati
                </a>
            </h3>
            <p class="mt-1 mb-1 text-sm text-gray-400">Stok : 1</p>
            <div class="flex justify-between items-center">
            <p class="font-semibold text-red-400 mr-2 mb-3">Rp 2.000</p>
            <button class="text-sm text-white bg-purple-400 px-1.5 py-1.5 mr-2 mb-3 rounded-md tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                </svg>
            </button>
            </div>
        </div>
    </div>
    </div>
<!-- penutup kontainer pembungkus semua card -->
</div>


</div>
@endsection
