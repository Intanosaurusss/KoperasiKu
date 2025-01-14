<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\RegisterMemberController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SaranController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Models\Produk;

// route untuk halaman default
Route::get('/', function () {
    $produk = Produk::take(5)->get(); // Ambil 5 data produk untuk ditampilkan di landingpage section produk
    return view('welcome', ['produk' => $produk]);
});

// route untuk menampilkan halaman login
Route::get('/login', function () { return view('pages.login'); });
Route::post('/login', [LoginController::class, 'login'])->name('login'); 
Route::get('/logout', [LoginController::class, 'logout'])->name('logout'); 
Route::get('/logoutadmin', [LoginController::class, 'logoutadmin'])->name('logout.admin'); 

// Halaman Admin (Hanya untuk admin yang sudah login)
Route::middleware(['auth:admin'])->group(function () {
    // Route untuk menampilkan dashboard admin
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])->name('pages-admin.dashboard-admin');
    Route::get('/grafik-data', [DashboardAdminController::class, 'getgrafikdata']); // Untuk grafik data di dashboard admin

    // Menampilkan halaman member
    Route::get('/member', [RegisterMemberController::class, 'index'])->name('pages-admin.member');
    Route::get('/member/{id}', [RegisterMemberController::class, 'show'])->name('detail-member');  // Menampilkan detail member berdasarkan ID
    Route::get('/tambah-member', [RegisterMemberController::class, 'create'])->name('tambah-member.create');
    Route::post('/member', [RegisterMemberController::class, 'store'])->name('tambah-member');
    Route::delete('/member/{id}', [RegisterMemberController::class, 'destroy'])->name('member.destroy');
    Route::post('/tambah-member-excel', [RegisterMemberController::class, 'importexcel'])->name('import-excel.member');

    // Route untuk menampilkan menu pengeluaran admin
    Route::get('/pengeluaran-admin', [PengeluaranController::class, 'index'])->name('pages-admin.pengeluaran-admin');
    Route::get('/pengeluaran-admin/tambah', [PengeluaranController::class, 'create'])->name('tambah-pengeluaran-admin');
    Route::post('/pengeluaran-admin', [PengeluaranController::class, 'store'])->name('pengeluaran-admin');
    Route::get('/detail-pengeluaran-admin/{id}', [PengeluaranController::class, 'show'])->name('detail-pengeluaran-admin');
    Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::post('/pengeluaran/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');
    Route::get('/pengeluaran/{id}/cetak', [PengeluaranController::class, 'cetakpengeluaranbyid'])->name('cetakpengeluaranbyid.cetak');
    Route::get('/pengeluaran/cetakbydate', [PengeluaranController::class, 'cetakpengeluaranbydate'])->name('cetakpengeluaranbydate.cetak');

    // Route untuk menampilkan menu produk admin
    Route::get('/produk-admin', [ProdukController::class, 'index'])->name('pages-admin.produk-admin');
    Route::get('/produk-admin/tambah', [ProdukController::class, 'create'])->name('tambah-produk-admin');
    Route::post('/produk-admin', [ProdukController::class, 'store'])->name('produk-admin');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk-admin.edit');
    Route::post('/produk/{id}', [ProdukController::class, 'update'])->name('produk-admin.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk-admin.destroy');

    // Route untuk menampilkan menu riwayat admin
    Route::get('/riwayat-admin', [RiwayatController::class, 'indexadmin'])->name('riwayat-admin.index');
    Route::get('/riwayat-admin/{id}', [RiwayatController::class, 'showadmin'])->name('riwayat-admin.show');
    Route::get('/riwayat-admin/{id}/cetak', [RiwayatController::class, 'cetakriwayatadmin'])->name('cetakriwayatadminbyid');
    Route::post('/riwayat-admin/cetakbydate', [RiwayatController::class, 'cetakriwayatadminbydate'])->name('cetakriwayatadminbydate');

    // Route untuk menampilkan menu transaksi admin
    Route::get('/transaksi-admin', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi-admin/addtokeranjang', [TransaksiController::class, 'addtransaksitokeranjang'])->name('transaksi.addtokeranjang');
    Route::delete('/transaksi-admin/delete', [TransaksiController::class, 'hapuskeranjangbyadmin'])->name('transaksi.deletekeranjang');
    
    // Route untuk meng-handle pembayaran/checkout di menu transaksi admin
    Route::post('/transaksi-checkoutbyadmin', [TransaksiController::class, 'checkoutbyadmin'])->name('checkoutbyadmin');
    Route::post('/payment/successbyadmin', [TransaksiController::class, 'paymentsuccessbyadmin'])->name('paymentsuccessbyadmin');
    
    // Route untuk meng-handle search suggestion di halaman transaksi admin
    Route::get('/search-id-member', [TransaksiController::class, 'searchidmember'])->name('search.member.id');
    Route::get('/search-produk', [TransaksiController::class, 'searchproduk'])->name('search.produk');

    // Route untuk menampilkan menu saran admin
    Route::get('/saran-admin', [SaranController::class, 'indexadmin'])->name('saran.indexadmin');
    Route::delete('/saran-admin/{id}', [SaranController::class, 'destroy'])->name('saran.destroy');
});

// route untuk menampilkan menu profile admin dan user kode : (['auth:admin,web']), web = user
Route::middleware(['auth:admin,web'])->group(function () {
    Route::get('/profile', function () { return view('pages.profile'); });
    Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('pages.edit-profile');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
});

// HALAMAN/FITUR USER //
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->name('pages-user.dashboard-user');

    //route untuk menampilkan menu keranjang user
    Route::get('/keranjang-user', [KeranjangController::class, 'index'])->name('pages-user.keranjang-user');
    Route::post('/keranjang-user/add', [KeranjangController::class, 'addToCart'])->name('tambah-ke-keranjang');
    Route::delete('/keranjang-user/remove/{id}', [KeranjangController::class, 'removeFromCart'])->name('hapus-dari-keranjang');
    Route::patch('/keranjang-user/increment/{id}', [KeranjangController::class, 'incrementQty'])->name('tambah-qty');
    Route::patch('/keranjang-user/decrement/{id}', [KeranjangController::class, 'decrementQty'])->name('kurang-qty');

    //route untuk menampilkan menu riwayat user
    Route::get('/riwayat-user', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat-user/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
    Route::get('/riwayat-user{id}/cetak', [RiwayatController::class, 'cetakriwayat'])->name('cetakriwayatbyid');
    Route::post('/riwayat-user/cetakbydate', [RiwayatController::class, 'cetakriwayatdate'])->name('cetakriwayatbydate');

    //route untuk menampilkan menu saran user
    Route::get('/saran-user', [SaranController::class, 'index'])->name('saran.index');
    Route::post('/saran-user', [SaranController::class, 'store'])->name('saran.store');

    //ROUTE UNTUK MENGHANDLE PEMBAYARAN/TRANSAKSI USER
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/payment/success', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');
    // Route::post('/midtrans/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');     //route callback midtrans
});
