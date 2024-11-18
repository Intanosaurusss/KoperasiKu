<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\User\KeranjangController;

// route untuk halaman default
Route::get('/', function () { return view('welcome'); });

// route untuk menampilkan halaman 
Route::get('/login', function () { return view('pages.login'); });
Route::post('/login', [LoginController::class, 'login'])->name('login'); 

//route untuk register
Route::get('/register', [RegisterController::class, 'index'])->name('pages.register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// HALAMAN ADMIN //
// route untuk menampilkan dashboard admin
Route::get('/dashboard-admin', function () { return view('pages-admin.dashboard-admin'); });
Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])->name('pages-admin.dashboard-admin');

// route untuk menampilkan menu pengeluaran admin
Route::get('/pengeluaran-admin', [PengeluaranController::class, 'index'])->name('pages-admin.pengeluaran-admin');
Route::get('/pengeluaran-admin/tambah', [PengeluaranController::class, 'create'])->name('tambah-pengeluaran-admin');
Route::post('/pengeluaran-admin', [PengeluaranController::class, 'store'])->name('pengeluaran-admin');
Route::get('/detail-pengeluaran-admin/{id}', [PengeluaranController::class, 'show'])->name('detail-pengeluaran-admin');
Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
Route::post('/pengeluaran/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');
Route::get('/pengeluaran/{id}/cetak', [PengeluaranController::class, 'cetakpengeluaranbyid'])->name('cetakpengeluaranbyid.cetak');
Route::get('/pengeluaran/cetakbydate', [PengeluaranController::class, 'cetakpengeluaranbydate'])->name('cetakpengeluaranbydate.cetak');

// route untuk menampilkan menu produk admin
Route::get('/produk-admin', [ProdukController::class, 'index'])->name('pages-admin.produk-admin');
Route::get('/produk-admin/tambah', [ProdukController::class, 'create'])->name('tambah-produk-admin');
Route::post('/produk-admin', [ProdukController::class, 'store'])->name('produk-admin');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk-admin.edit');
Route::post('/produk/{id}', [ProdukController::class, 'update'])->name('produk-admin.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk-admin.destroy');

// route untuk menampilkan menu riwayat admin
Route::get('/riwayat-admin', function () { return view('pages-admin.riwayat-admin'); });
Route::get('/detail-riwayat-pembelian', function () { return view('pages-admin.detail-riwayat-pembelian'); });
Route::get('/detail-riwayat-pembelian-by-date', function () { return view('pages-admin.detail-riwayat-pembelian-by-date'); }); //untuk template file pdf laporan pembelian by date

// route untuk menampilkan menu profile admin dan user
Route::get('/profile', function () { return view('pages.profile'); });
Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('pages.edit-profile');
Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

// HALAMAN USER //
// route untuk menampilkan dashboard user
Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->name('pages-user.dashboard-user');

//route untuk menampilkan menu keranjang user
Route::get('/keranjang-user', [KeranjangController::class, 'index'])->name('pages-user.keranjang-user');
Route::post('/keranjang-user/add', [KeranjangController::class, 'addToCart'])->name('tambah-ke-keranjang');
Route::delete('/keranjang-user/remove/{id}', [KeranjangController::class, 'removeFromCart'])->name('hapus-dari-keranjang');
Route::patch('/keranjang-user/increment/{id}', [KeranjangController::class, 'incrementQty'])->name('tambah-qty');
Route::patch('/keranjang-user/decrement/{id}', [KeranjangController::class, 'decrementQty'])->name('kurang-qty');

//route untuk menampilkan menu riwayat user
Route::get('/riwayat-user', function () { return view('pages-user.riwayat-user'); });