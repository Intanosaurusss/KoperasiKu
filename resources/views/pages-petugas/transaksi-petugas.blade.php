@extends('components.layout-petugas')

@section('title', 'Transaksi Pembelian Petugas')

@section('content')

<!-- IMPORT JAVASCRIPT DARI MIDTRANS (SNAP) -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ ('services.midtrans.client_key') }}"></script>

<div class="p-2">

    <!-- informasi halaman -->
    <div class="flex items-center p-4 mb-4 text-sm text-purple-700 rounded-lg bg-purple-200" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium">Info!</span> Ini adalah halaman transaksi pembelian oleh petugas
        </div>
    </div>
    
    <!-- popup pesan sukses/gagal respon dari backend -->
    @if(session('success'))
        <div id="success-message" class="alert bg-green-100 text-green-700 text-sm border border-green-400 rounded p-2 mb-2">
        <strong class="font-bold">Sukses!</strong>
             {{ session('success') }}
        </div>
        @endif
    @if(session('error'))
        <div id="error-message" class="alert bg-red-100 text-red-700 text-sm border border-red-400 rounded p-2 mb-2">
        <strong class="font-bold">Gagal!</strong>
            {{ session('error') }}
        </div>
    @endif

    <!-- form input transaksi ke tabel keranjang sblm di checkout  -->
    <div class="flex flex-col lg:flex-row gap-6">
    <!-- Form Transaksi Pembelian -->
    <div class="bg-white p-3 rounded-lg shadow lg:w-1/3 max-h-96 overflow-y-auto">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Form Tambah ke Keranjang</h2>
    <form id="transaksiForm" action="{{ route('transaksi-petugas.addtokeranjang') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 gap-1">
            <div class="space-y-1">
                <label for="id_member" class="block text-sm font-medium text-gray-700">ID Member</label>
                <input type="text" id="id_member_1" data-id="1" name="id_member" 
                    class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" 
                    placeholder="Silahkan isi id membernya" onkeyup="searchMember(this)">
                <!-- Hasil pencarian -->
                <ul id="member_suggestions_1" data-id="1" class="mt-2 space-y-1"></ul>
            </div>
            <div id="produk-wrapper" class="space-y-1">
                <div class="flex items-center gap-2 produk-row">
                    <div class="w-4/5">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700">Produk</label>
                        <input type="text" name="nama_produk[]" class="nama-produk block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" placeholder="Silahkan isi produknya">
                        <ul class="produk-suggestions mt-2 space-y-1"></ul>
                    </div>
                    <div class="w-1/5">
                        <label for="qty" class="block text-sm font-medium text-gray-700">Qty</label>
                        <input type="number" name="qty[]" class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" placeholder="Qty" min="1">
                    </div>
                    <button type="button" class="px-1.5 py-0.5 bg-green-500 text-white rounded hover:bg-green-600 add-row">+</button>
                    <button type="button" class="px-1.5 py-0.5 bg-red-500 text-white rounded hover:bg-red-600 remove-row hidden">-</button>
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-2 py-1.5 bg-purple-600 text-white rounded hover:bg-purple-700">Tambah</button>
        </div>
    </form>
    </div>

    <!-- Data Transaksi -->
    <div class="bg-white p-3 rounded-lg shadow flex-1">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Data Keranjang</h2>
        <!-- input search data member untuk ditampilkan datanya -->
        <div class="space-y-1 mb-2">
            <form method="GET" action="{{ route('transaksi-petugas.index') }}">
            <label for="id_member" class="block text-sm font-medium text-gray-700">ID Member</label>
            <div  class="flex items-center space-x-2">
            <input type="text" id="id_member_2" data-id="2" name="id_member" 
                class="block text-sm w-full text-gray-600 py-1.5 pl-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md placeholder:text-gray-400" 
                placeholder="Silahkan isi id membernya" onkeyup="searchMember(this)" value="{{ request('id_member') }}">
                <button type="submit" class="px-2 py-1.5 bg-purple-600 text-white rounded hover:bg-purple-700">Cari</button>
            </div>
            <ul id="member_suggestions_2" data-id="2" class="mt-2 space-y-1"></ul>
            </form>
        </div>
        <div class="overflow-y-auto max-h-64">
        <div class="min-w-full w-64">
             <table class="w-full text-sm text-left text-gray-500">
                <thead class="bg-gray-200 text-gray-700 uppercase">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Qty</th>
                        <th class="px-6 py-3">Harga</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksiTable">
                    @forelse($keranjang as $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $item->produk->nama_produk }}</td>
                        <td class="px-6 py-4">{{ $item->qty }}</td>
                        <td class="px-6 py-4">{{ number_format($item->produk->harga_produk, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                        <form action="{{ route('transaksi-petugas.deletekeranjang') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id_keranjang" value="{{ $item->id }}">
                                <button class="flex items-center space-x-2 bg-red-400 hover:bg-red-500 p-1 rounded-md text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    <span class="hidden lg:block text-sm">Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-4">Keranjang kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
        <div class="flex justify-end mt-1 space-x-2 items-center">
            <p>Subtotal : <span class="text-red-400 font-semibold">Rp {{ $formattedSubtotal }}</span></p>
            <button 
            type="button" 
            onclick="openModal()" 
            class="px-2 py-1.5 bg-purple-600 text-white rounded hover:bg-purple-700 disabled:bg-gray-400 disabled:cursor-not-allowed" {{ $formattedSubtotal == 0 ? 'disabled' : '' }}>
            Bayar
            </button>
        </div>
    </div>
    </div>
    
</div>

<!-- modal pilih metode pembayaran -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="closeModalOnOutsideClick(event)">
    <div class="bg-white rounded-lg shadow-lg p-6 w-80">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</h2>
        <div class="flex justify-between space-x-4">
            <button id="cashButton" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md" onclick="selectPayment('cash')">
                Cash
            </button>
            <button id="digitalButton" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md" onclick="selectPayment('digital')">
                Digital Payment
            </button>
        </div>
    </div>
</div>

<script>
    //ini untuk suggestion search member
    function searchMember(inputElement) {
    const id = inputElement.getAttribute('data-id');
    const input = inputElement.value.trim(); // Menghapus spasi di awal/akhir
    const suggestionsList = document.querySelector(`#member_suggestions_${id}`);

    // Jika input kosong, hapus semua suggestion
    if (input.length < 1) {
        suggestionsList.innerHTML = '';
        return;
    }

    // Fetch data dari server berdasarkan input
    fetch(`/petugas-search-id-member?nama=${input}`)
        .then(response => response.json())
        .then(data => {
            suggestionsList.innerHTML = ''; // Kosongkan suggestion sebelumnya

            data.forEach(member => {
                const li = document.createElement('li');
                li.textContent = `ID: ${member.id_member} - ${member.nama}`;
                li.classList.add('p-2', 'border', 'border-gray-300', 'text-gray-600', 'text-sm', 'font-poppins', 'rounded-md', 'cursor-pointer');
                li.onclick = () => selectMember(member, id);
                suggestionsList.appendChild(li);
            });
        });
    }

    // select member
    function selectMember(member, id) {
        const inputElement = document.querySelector(`#id_member_${id}`);
        const suggestionsList = document.querySelector(`#member_suggestions_${id}`);

        // Set nilai input dan hapus suggestion
        inputElement.value = member.id_member;
        suggestionsList.innerHTML = '';
    }

    // Event tambahan untuk menyembunyikan suggestion jika input fokus di luar
    document.addEventListener('click', (event) => {
        const suggestions = document.querySelectorAll('ul[id^="member_suggestions_"]');
        suggestions.forEach((suggestion) => {
            if (!suggestion.contains(event.target)) {
                suggestion.innerHTML = '';
            }
        });
    });

    // untuk menambah dan menghapus baris produk dan qty dari baris 207 - 243
    document.addEventListener('DOMContentLoaded', function () {
    const produkWrapper = document.getElementById('produk-wrapper');

    // Event listener untuk menambah baris
    produkWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-row')) {
            const lastRow = produkWrapper.querySelector('.produk-row:last-child');
            const newRow = lastRow.cloneNode(true);

            // Reset nilai input pada baris baru
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelectorAll('ul').forEach(ul => ul.innerHTML = '');

            // Tampilkan tombol remove di row baru
            newRow.querySelector('.remove-row').classList.remove('hidden');

            produkWrapper.appendChild(newRow);
        }
    });

    // Event listener untuk menghapus baris
    produkWrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('.produk-row');
            if (produkWrapper.querySelectorAll('.produk-row').length > 1) {
                row.remove();
            }
        }
    });

    // Event listener untuk search produk
    produkWrapper.addEventListener('keyup', function (e) {
        if (e.target.classList.contains('nama-produk')) {
            searchProduk(e.target);
        }
    });
    
    // Event listener untuk menyembunyikan suggestion produk saat input kehilangan fokus
    produkWrapper.addEventListener('blur', function (e) {
        if (!e.target.classList.contains('nama-produk') && !e.target.closest('.produk-suggestions')) {
            const suggestions = produkWrapper.querySelectorAll('.produk-suggestions');
            suggestions.forEach(suggestion => suggestion.innerHTML = ''); // Menyembunyikan daftar suggestion
        }
    }, true); // Event bubbling

    // Menambahkan event click pada document untuk menyembunyikan suggestion produk saat klik di luar
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.produk-row')) {
            const suggestions = produkWrapper.querySelectorAll('.produk-suggestions');
            suggestions.forEach(suggestion => suggestion.innerHTML = ''); // Menyembunyikan daftar suggestion
        }
    });
    });

    // Suggestion untuk search produk
    function searchProduk(input) {
        const row = input.closest('.produk-row');
        const inputValue = input.value;
        const suggestionsList = row.querySelector('.produk-suggestions');

        if (inputValue.length < 1) {
            suggestionsList.innerHTML = '';
            return;
        }

        fetch(`/petugas-search-produk?nama_produk=${inputValue}`) // fetch data produk dari backend 
            .then(response => response.json())
            .then(data => {
                suggestionsList.innerHTML = '';

                data.forEach(produk => {
                    const li = document.createElement('li');
                    li.textContent = produk.nama_produk;
                    li.classList.add('p-2', 'border', 'border-gray-300', 'text-gray-600', 'text-sm', 'font-poppins', 'rounded-md', 'cursor-pointer');
                    li.onclick = () => selectProduk(produk, row);
                    suggestionsList.appendChild(li);
                });
            });
    }

    // Function untuk select produk
    function selectProduk(produk, row) {
        const inputProduk = row.querySelector('.nama-produk');
        const suggestionsList = row.querySelector('.produk-suggestions');
        inputProduk.value = produk.nama_produk;
        suggestionsList.innerHTML = '';
    }

    // Menghilangkan pesan popup setelah 3 detik, lihat di kode baris 28-38
    setTimeout(() => {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        if (successMessage) successMessage.style.display = 'none';
        if (errorMessage) errorMessage.style.display = 'none';
    }, 3000); 

    // javascript untuk mengatur popup metode pembayaran saat checkout
    const modal = document.getElementById('paymentModal');
    const cashButton = document.getElementById('cashButton');
    const digitalButton = document.getElementById('digitalButton');

    // Fungsi untuk membuka modal
    function openModal() {
        modal.classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        modal.classList.add('hidden');
    }

    // Tutup modal jika mengklik di luar area modal
    function closeModalOnOutsideClick(event) {
        if (event.target === modal) {
            closeModal();
        }
    }

    // Fungsi untuk memilih metode pembayaran
    function selectPayment(method) {
        // Disable kedua tombol dan beri warna abu-abu
        cashButton.disabled = true;
        digitalButton.disabled = true;
        cashButton.classList.add('bg-gray-500', 'hover:bg-gray-500', 'cursor-not-allowed');
        digitalButton.classList.add('bg-gray-500', 'hover:bg-gray-500', 'cursor-not-allowed');

        // Tampilkan pesan metode pembayaran yang dipilih
        showFlashMessage(`Anda memilih metode pembayaran: ${method}`, 'info');

        // Tentukan logika untuk masing-masing metode pembayaran
        if (method === 'cash') {
            // Kirim permintaan ke server untuk pembayaran cash
            fetch("{{ route('checkoutbypetugas') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ metode_pembayaran: 'cash' })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal melakukan checkout.');
                }
                return response.json();
            })
            .then(data => {
                // Tampilkan pesan sukses
                showFlashMessage(data.message, 'success');
                closeModal(); // Menutup modal setelah proses selesai
                location.reload(); // Refresh halaman
            })
            .catch(error => {
                // Tampilkan pesan error
                showFlashMessage('Terjadi kesalahan: ' + error.message, 'error');
            });
        } else if (method === 'digital') {
            fetch("{{ route('checkoutbypetugas') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ metode_pembayaran: 'digital' })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal melakukan checkout.');
                }
                return response.json();
            })
            .then(data => {
                if (data.snapToken) {
                    snap.pay(data.snapToken, {
                        onSuccess: function (result) {
                            // Kirim data ke server untuk memperbarui status pembayaran
                            fetch("{{ route('paymentsuccessbypetugas') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({ order_id: result.order_id })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Gagal memperbarui status pembayaran.');
                                }
                                return response.json();
                            })
                            .then(data => {
                                showFlashMessage(data.message, 'success');
                                location.reload(); // Refresh halaman setelah sukses
                            })
                            .catch(error => {
                                showFlashMessage('Terjadi kesalahan: ' + error.message, 'error');
                            });
                        },
                        onPending: function () {
                            showFlashMessage('Menunggu pembayaran...', 'info');
                        },
                        onError: function () {
                            showFlashMessage('Pembayaran gagal!', 'error');
                        }
                    });
                }
            })
            .catch(error => {
                showFlashMessage('Terjadi kesalahan: ' + error.message, 'error');
            });
        }
    }

    // Fungsi untuk menampilkan flash message
    function showFlashMessage(message, type) {
        // Tentukan kelas CSS berdasarkan jenis pesan
        let flashMessageClass = '';
        let flashMessageTitle = '';

        if (type === 'success') {
            flashMessageClass = 'bg-green-100 border border-green-400 text-green-700';
            flashMessageTitle = 'Sukses!';
        } else if (type === 'error') {
            flashMessageClass = 'bg-red-100 border border-red-400 text-red-700';
            flashMessageTitle = 'Gagal!';
        } else if (type === 'info') {
            flashMessageClass = 'bg-blue-100 border border-blue-400 text-blue-700';
            flashMessageTitle = 'Informasi';
        }

        // Buat elemen flash message
        const flashMessage = document.createElement('div');
        flashMessage.className = `px-4 text-sm py-3 rounded my-4 ${flashMessageClass} max-w-full w-full mx-auto sm:max-w-xl md:max-w-full`;
        flashMessage.setAttribute('role', 'alert');
        
        flashMessage.innerHTML = `
            <strong class="font-bold">${flashMessageTitle}</strong>
            <span class="block sm:inline">${message}</span>
        `;

        // Cari container utama konten
        const mainContent = document.querySelector('main');
        if (mainContent) {
            mainContent.prepend(flashMessage);
        }

        // Hapus flash message setelah 5 detik
        setTimeout(() => {
            flashMessage.remove();
        }, 5000);
    }
</script>
@endsection