<?php

use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Retur\ReturPenjualanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Login, Home, Profile */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');


/* Data Karyawan */
Route::resource('data-karyawan', DivisiController::class)
    ->parameters(['data-karyawan' => 'ts_div']);

/* Data Retur */
Route::prefix('retur')->name('retur.')->group(function () {
    // RETUR PENJUALAN
    Route::get('penjualan', [ReturPenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('penjualan/data', [ReturPenjualanController::class, 'dataJson'])->name('penjualan.data');
    Route::get('penjualan/create', [ReturPenjualanController::class, 'create'])->name('penjualan.create');
    Route::get('penjualan/{id}/edit', [ReturPenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::put('penjualan/{id}', [ReturPenjualanController::class, 'updateHeader'])->name('penjualan.update');
    // DETAIL
    Route::get('penjualan/{id}/details', [ReturPenjualanController::class, 'detailsJson'])->name('penjualan.details.data');
    Route::post('penjualan/{id}/details', [ReturPenjualanController::class, 'storeDetail'])->name('penjualan.details.store');
    Route::put('penjualan/{id}/details/{detailId}', [ReturPenjualanController::class, 'updateDetail'])->name('penjualan.details.update');
    Route::delete('penjualan/{id}/details/{detailId}', [ReturPenjualanController::class, 'destroyDetail'])->name('penjualan.details.destroy');
    // DRAFT
    Route::delete('penjualan/{id}', [ReturPenjualanController::class, 'destroyHeader'])->name('penjualan.destroy');
    Route::put('penjualan/{id}/publish', [ReturPenjualanController::class, 'publish'])->name('penjualan.publish');
    Route::put('penjualan/{id}/publish-edit', [ReturPenjualanController::class, 'publishEdit'])->name('penjualan.publishEdit');
    // APPROVE
    Route::post('penjualan/approve-all', [ReturPenjualanController::class, 'approveAll'])->name('penjualan.approveAll');
    Route::post('penjualan/{id}/approve', [ReturPenjualanController::class, 'approve'])->name('penjualan.approve');
    // PRINT
    Route::get('penjualan/print-all', [ReturPenjualanController::class, 'printAll'])->name('penjualan.printAll');
    Route::get('penjualan/{id}/print', [ReturPenjualanController::class, 'print'])->name('penjualan.print');
});
