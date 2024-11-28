@extends('components.layout-user')

@section('title', 'Keranjang User')

@section('content')
<div>
    @if ($keranjang->isNotEmpty())
        <p class="text-md text-gray-600">Ayo monggo, silahkan di checkout...</p>
    @else
        <p class="text-md text-gray-600">Keranjang kamu masih kosong</p>
    @endif

    <!-- flash popup untuk menampilkan sukses/gagalnya menghapus produk dari keranjang -->
    @if (session('success'))
    <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- container produk yang dimasukkan ke keranjang -->
    @foreach ($keranjang as $produk)
    <div class="flex items-center gap-4 p-4 border rounded-lg shadow-md w-full max-w-6xl mt-4 bg-white">
    <!-- Image Produk -->
    <img 
        src="{{ $produk->produk->foto_produk }}" 
        alt="{{ $produk->produk->nama_poduk }}" 
        class="w-24 h-24 object-cover rounded-md"
    />

    <!-- Informasi Produk -->
    <div class="flex-1 space-y-1">
        <h2 class="text-sm font-semibold text-gray-700">{{ $produk->produk->nama_produk }}</h2>
        <p class="text-sm text-gray-500">Stok: <span class="font-medium">{{ $produk->produk->stok_produk }}</span></p>
        <p class="text-red-400 font-semibold">{{ $produk->produk->harga_produk }}</p>
    </div>

    <!-- Kontrol Jumlah 2 -->
    <div class="quantity-control flex items-center gap-2 mt-4">

    <!-- Tombol dicrease/kurangi jumlah -->
    <form action="{{ route('kurang-qty', $produk->id) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <button type="submit" class="decrease bg-red-400 text-white px-2 py-1 rounded-lg hover:bg-red-500 transition">-</button>
    </form>

    <!-- Tampilan Jumlah -->
    <span class="quantity w-8 text-center">{{ $produk->qty }}</span>

    <!-- Tombol increase/tambahi jumlah -->
    <form action="{{ route('tambah-qty', $produk->id) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <button type="submit" class="increase bg-blue-500 text-white px-2 py-1 rounded-lg hover:bg-blue-600 transition">+</button>
    </form>

    <!-- button hapus produk dari keranjang -->
    <form action="{{ route('hapus-dari-keranjang', $produk->id) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button class="flex items-center space-x-2 bg-red-400 hover:bg-red-500 p-1 rounded-md text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        <span class="hidden lg:block text-sm">Hapus</span>
    </button>
    </form>

    </div>
    </div>
    @endforeach 
    
    <div class="flex justify-end mt-5 space-x-2">
        <p class=" flex items-center text-gray-700">Subtotal pembelian : <span class="font-semibold text-red-500">Rp. {{ $formattedSubtotal}}</span></p>
        <button onclick="openModal()" class="flex items-center space-x-2 bg-purple-400 hover:bg-purple-600 p-2 rounded-md text-white">
            <span class="text-sm">checkout</span>
        </button>
    </div>
    
</div>

<!-- modal pilih metode pembayaran -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="closeModalOnOutsideClick(event)">
    <div class="bg-white rounded-lg shadow-lg p-6 w-80">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</h2>
        <div class="flex justify-between space-x-4">
            <button class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md" onclick="selectPayment('cash')">
                Cash
            </button>
            <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md" onclick="selectPayment('digital')">
                Digital Payment
            </button>
        </div>
    </div>
</div>

<script>
    // Ambil semua kontrol jumlah
    const quantityControls = document.querySelectorAll('.quantity-control');

    // Loop melalui setiap kontrol jumlah
    quantityControls.forEach(control => {
    // Ambil elemen terkait
    const quantitySpan = control.querySelector('.quantity');
    const decreaseButton = control.querySelector('.decrease');
    const increaseButton = control.querySelector('.increase');

    // Ambil nilai awal dari elemen span
    let quantity = parseInt(quantitySpan.textContent, 10);

    // Fungsi untuk memperbarui tampilan jumlah
    function updateQuantityDisplay() {
        quantitySpan.textContent = quantity;
    }

    // Event listener untuk tombol "-"
    decreaseButton.addEventListener('click', () => {
        if (quantity > 1) {
            quantity--; // Kurangi jumlah
            updateQuantityDisplay(); // Perbarui tampilan
        }
    });

    // Event listener untuk tombol "+"
    increaseButton.addEventListener('click', () => {
        quantity++; // Tambah jumlah
        updateQuantityDisplay(); // Perbarui tampilan
    });
    });

    //untuk mengatur flash message popup menghapus produk dari keranjang
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.remove();
            }, 3000); // Hapus pesan setelah 3 detik
        }
    });


    //javascript untuk mengatur popup metode pembayaran saat checkout
    const modal = document.getElementById('paymentModal');

    function openModal() {
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function selectPayment(method) {
        alert(`Anda memilih metode pembayaran: ${method}`);
        closeModal();
    }

// Tutup modal jika mengklik di luar area modal
function closeModalOnOutsideClick(event) {
    if (event.target === modal) {
        closeModal();
    }
    }
</script>
@endsection