<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControllerSP\PelangganController;
use App\Http\Controllers\ControllerSP\DaftarPesananController;
use App\Http\Controllers\ControllerSP\PenjualanController;
use App\Http\Controllers\DataKaryawan\DivisiController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('data-karyawan', DivisiController::class)->parameters(['data-karyawan' => 'ts_div']);

    Route::resource('pelanggan', PelangganController::class);
    Route::resource('customer-orders', DaftarPesananController::class);
    Route::resource('penjualan', PenjualanController::class)->only(['index', 'store']);


        Route::prefix('api')->name('api.')->group(function () {
        Route::prefix('jualan')->name('jualan.')->group(function () {
            Route::get('/outstanding-orders/{pelanggan}', [PenjualanController::class, 'getOutstandingOrders'])->name('outstanding-orders');
            Route::get('/order-details/{customerOrder}', [PenjualanController::class, 'getOrderDetails'])->name('order-details');
        });
    });
});
