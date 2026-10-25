```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPegawaiController;
use App\Http\Controllers\DashboardPemilikController;
use App\Http\Controllers\BarangController;

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

// Dashboard customer
Route::get('/customer', [CustomerController::class, 'index'])
    ->name('customer.dashboard');

// Dashboard pegawai
Route::get('/pegawai/dashboard', [DashboardPegawaiController::class, 'index'])
    ->name('pegawai.dashboard');

// Dashboard pemilik
Route::get('/pemilik/dashboard', [DashboardPemilikController::class, 'index'])
    ->name('pemilik.dashboard');

// Kelola barang
Route::resource('barang', BarangController::class);
