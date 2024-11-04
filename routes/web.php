<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;

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
Route::get('/pengeluaran-admin', function () { return view('pages-admin.pengeluaran-admin'); });
Route::get('/detail-pengeluaran-admin', function () { return view('pages-admin.detail-pengeluaran-admin'); });
Route::get('/tambah-pengeluaran-admin', function () {return view('pages-admin.form-admin.tambah-pengeluaran-admin'); });
Route::get('/edit-pengeluaran-admin', function () { return view('pages-admin.form-admin.edit-pengeluaran-admin'); });

// route untuk menampilkan menu produk admin
Route::get('/produk-admin', function () { return view('pages-admin.produk-admin'); });
Route::get('/tambah-produk-admin', function () { return view('pages-admin.form-admin.tambah-produk-admin'); });
Route::get('/edit-produk-admin', function () { return view('pages-admin.form-admin.edit-produk-admin'); });

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
Route::get('/keranjang-user', function () { return view('pages-user.keranjang-user'); })->name('pages-user.keranjang-user');

//route untuk menampilkan menu riwayat user
Route::get('/riwayat-user', function () { return view('pages-user.riwayat-user'); });