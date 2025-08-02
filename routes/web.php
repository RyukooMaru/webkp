<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutasiGudang\WarehouseController;
use App\Http\Controllers\MutasiGudang\GudangOrderController;
use App\Http\Controllers\MutasiGudang\TransferGudangController;
use App\Http\Controllers\MutasiGudang\TerimaGudangController;
use App\Http\Controllers\TestController;
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



Route::prefix('mutasigudang')->middleware(['auth'])->group(function () {

// Gudang
    Route::resource('warehouse', WarehouseController::class);

// Optional JSON endpoint (untuk AJAX edit)
    Route::get('/{id}/json', [WarehouseController::class, 'json'])->name('json');

// Permintaan Gudang (Gudang Order)
    Route::get('gudangorder', [GudangOrderController::class, 'index'])->name('gudangorder.index');
    Route::get('gudangorder/create', [GudangOrderController::class, 'create'])->name('gudangorder.create');
    Route::get('gudangorder/{id}/edit', [GudangOrderController::class, 'edit'])->name('gudangorder.edit');
    Route::get('gudangorder/{order}', [GudangOrderController::class, 'show'])->name('gudangorder.show');
    Route::delete('gudangorder/{id}', [GudangOrderController::class, 'destroy'])->name('gudangorder.destroy');
    Route::put('gudangorder/{id}/update-header', [GudangOrderController::class, 'updateHeader'])->name('gudangorder.updateHeader');
    Route::put('gudangorder/{order}/submit', [GudangOrderController::class, 'submit'])->name('gudangorder.submit');
    Route::post('gudangorder/detail/store', [GudangOrderController::class, 'storeDetail'])->name('gudangorder.storeDetail');
    Route::delete('gudangorder/{order}/details/{detail}', [GudangOrderController::class, 'destroyDetail'])->name('gudangorder.destroyDetail');

// Transfer Gudang
    Route::get('transfergudang', [TransferGudangController::class, 'index'])->name('transfergudang.index');
    Route::get('transfergudang/create', [TransferGudangController::class, 'create'])->name('transfergudang.create');
    Route::get('transfergudang/{id}/edit', [TransferGudangController::class, 'edit'])->name('transfergudang.edit');
    Route::get('/transfergudang/{transfer}', [TransferGudangController::class, 'show'])->name('transfergudang.show');
    Route::post('transfergudang/detail/store', [TransferGudangController::class, 'storeDetail'])->name('transfergudang.storeDetail');
    Route::delete('transfergudang/{id}', [TransferGudangController::class, 'destroy'])->name('transfergudang.destroy');
    Route::put('transfergudang/{id}/update-header', [TransferGudangController::class, 'updateHeader'])->name('transfergudang.updateHeader');
    Route::delete('transfergudang/{transfer}/details/{detail}', [TransferGudangController::class, 'destroyDetail'])->name('transfergudang.destroyDetail');
    Route::put('transfergudang/{transfer}/submit', [TransferGudangController::class, 'submit'])->name('transfergudang.submit');
    Route::get('transfergudang/fetch-details/{permintaanId}', [TransferGudangController::class, 'fetchPermintaanDetails'])->name('transfergudang.fetchDetails');
    Route::post('transfergudang/{id}/sync-details', [TransferGudangController::class, 'syncDetailsFromPermintaan'])->name('transfergudang.syncDetails');

// PenerimaanGudang
    Route::get('terimagudang', [TerimaGudangController::class, 'index'])->name('terimagudang.index');
    Route::get('terimagudang/create', [TerimaGudangController::class, 'create'])->name('terimagudang.create');
    Route::post('terimagudang/store', [TerimaGudangController::class, 'store'])->name('terimagudang.store');
    Route::get('terimagudang/{id}/edit', [TerimaGudangController::class, 'edit'])->name('terimagudang.edit');
    Route::put('terimagudang/{id}', [TerimaGudangController::class, 'update'])->name('terimagudang.update');
    Route::delete('terimagudang/{id}', [TerimaGudangController::class, 'destroy'])->name('terimagudang.destroy');
    Route::get('terimagudang/get-transfer-details/{id}', [TerimaGudangController::class, 'getTransferDetails'])->name('terimagudang.getTransferDetails');


});
