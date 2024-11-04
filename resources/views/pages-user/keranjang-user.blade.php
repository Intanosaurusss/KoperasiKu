@extends('components.layout-user')

@section('title', 'Keranjang User')

@section('content')
<div>
    <p class="text-md text-gray-600">ayo monggo, silahkan di checkout...</p>

    <!-- container produk yang dimasukkan ke keranjang -->
    <div class="flex items-center gap-4 p-4 border rounded-lg shadow-md w-full max-w-6xl mt-4">
    <!-- Image Produk -->
    <img 
        src="https://via.placeholder.com/150" 
        alt="Produk" 
        class="w-24 h-24 object-cover rounded-md"
    />

    <!-- Informasi Produk -->
    <div class="flex-1 space-y-1">
        <h2 class="text-sm font-semibold text-gray-700">Nabati</h2>
        <p class="text-sm text-gray-500">Stok: <span class="font-medium">10</span></p>
        <p class="text-red-400 font-semibold">Rp 2.000</p>
    </div>

    <!-- Kontrol Jumlah 2 -->
    <div class="quantity-control flex items-center gap-2 mt-4">
        <button class="decrease bg-red-400 text-white px-2 py-1 rounded-lg hover:bg-gray-400 transition">-</button>
        <span class="quantity w-8 text-center">1</span>
        <button class="increase bg-blue-500 text-white px-2 py-1 rounded-lg hover:bg-blue-600 transition">+</button>
        <button class="flex items-center space-x-2 bg-red-400 hover:bg-red-500 p-1 rounded-md text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            <span class="hidden lg:block text-sm">Hapus</span>
        </button>
    </div>
    </div>

    <div class="flex justify-end mt-5 space-x-2">
        <p class=" flex items-center text-gray-700">Subtotal pembelian : <span class="font-semibold text-red-500"> Rp. 2000 </span></p>
        <button class="flex items-center space-x-2 bg-purple-400 hover:bg-purple-600 p-2 rounded-md text-white">
            <span class="text-sm">Checkout</span>
        </button>
    </div>

</div>

<script>
    // Ambil semua kontrol jumlah
    const quantityControls = document.querySelectorAll('.quantity-control');

    // Loop melalui setiap kontrol jumlah
    quantityControls.forEach(control => {
        let quantity = 1; // Nilai awal untuk setiap kontrol

        const quantitySpan = control.querySelector('.quantity');
        const decreaseButton = control.querySelector('.decrease');
        const increaseButton = control.querySelector('.increase');

        // Fungsi untuk memperbarui tampilan jumlah
        function updateQuantityDisplay() {
            quantitySpan.textContent = quantity;
        }

        // Event listener untuk tombol "-"
        decreaseButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                updateQuantityDisplay();
            }
        });

        // Event listener untuk tombol "+"
        increaseButton.addEventListener('click', () => {
            quantity++;
            updateQuantityDisplay();
        });
    });
</script>
@endsection