<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangManagementController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Gunakan Resource Route untuk konsistensi
Route::resource('barang', BarangManagementController::class);
Route::resource('pembeli', PembeliController::class);
Route::resource('transaksi', TransaksiController::class);