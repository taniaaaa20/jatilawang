<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\CustomerController;

Route::get('/customer', [CustomerController::class, 'index'])
    ->name('customer.dashboard');


use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/pemilik/dashboard', function () {
    if (session('role') !== 'pemilik') {
        return redirect()->route('login');
    }

    return view('pemilik.dashboard');
})->name('pemilik.dashboard');

use App\Http\Controllers\DashboardPegawaiController;

Route::get('/pegawai/dashboard', [
    DashboardPegawaiController::class,
    'index'
])->name('pegawai.dashboard');


use App\Http\Controllers\DashboardPemilikController;

Route::get('/pemilik/dashboard', [
    DashboardPemilikController::class,
    'index'
])->name('pemilik.dashboard');

