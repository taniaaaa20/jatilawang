<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPegawaiController;
use App\Http\Controllers\DashboardPemilikController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiRentalController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LaporanKeuanganController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Login dan logout
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Dashboard customer lama
Route::get('/customer', [CustomerController::class, 'index'])
    ->name('customer.dashboard');

// Dashboard pegawai
Route::get('/pegawai/dashboard', [DashboardPegawaiController::class, 'index'])
    ->name('pegawai.dashboard');

// Dashboard pemilik
Route::get('/pemilik/dashboard', [DashboardPemilikController::class, 'index'])
    ->name('pemilik.dashboard');

// Kelola Pegawai
Route::get('/pemilik/pegawai', [PegawaiController::class, 'index'])
    ->name('pemilik.pegawai.index');

Route::get('/pemilik/pegawai/tambah', [PegawaiController::class, 'create'])
    ->name('pemilik.pegawai.create');

Route::post('/pemilik/pegawai', [PegawaiController::class, 'store'])
    ->name('pemilik.pegawai.store');

Route::get('/pemilik/pegawai/{id}/edit', [PegawaiController::class, 'edit'])
    ->name('pemilik.pegawai.edit');

Route::put('/pemilik/pegawai/{id}', [PegawaiController::class, 'update'])
    ->name('pemilik.pegawai.update');

Route::delete('/pemilik/pegawai/{id}', [PegawaiController::class, 'destroy'])
    ->name('pemilik.pegawai.destroy');

// Laporan Keuangan Pemilik
Route::get('/pemilik/laporan-keuangan', [LaporanKeuanganController::class, 'index'])
    ->name('pemilik.laporan-keuangan.index');

// Kelola barang
Route::resource('barang', BarangController::class);

// DATA PELANGGAN
// Bisa diakses pegawai dan pemilik

Route::get('/data-pelanggan', [CustomerController::class, 'dataPelanggan'])
    ->name('customer.index');

Route::post('/data-pelanggan', [CustomerController::class, 'store'])
    ->name('customer.store');

Route::put('/data-pelanggan/{id}', [CustomerController::class, 'update'])
    ->name('customer.update');

Route::delete('/data-pelanggan/{id}', [CustomerController::class, 'destroy'])
    ->name('customer.destroy');

// Transaksi Rental
Route::get('/pegawai/transaksi', [TransaksiRentalController::class, 'index'])
    ->name('transaksi.index');

Route::post('/pegawai/transaksi', [TransaksiRentalController::class, 'store'])
    ->name('transaksi.store');

Route::post('/pegawai/transaksi/{noNota}/kembalikan', [TransaksiRentalController::class, 'kembalikan'])
    ->name('transaksi.kembalikan');

Route::get('/pegawai/transaksi/{noNota}/nota', [TransaksiRentalController::class, 'nota'])
    ->name('transaksi.nota');

