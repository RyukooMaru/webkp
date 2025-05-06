<?php


use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Akuntansi\JurnalUmumController;
use App\Http\Controllers\Inventory\SupplierController;
use App\Http\Controllers\Keamanan\RoleController;
use App\Http\Controllers\Presensi\KaryawanController;
use App\Http\Controllers\SalesReturn\SalesReturnController;
use App\Http\Controllers\Comprof\SettingMenuController;
use App\Http\Controllers\Presensi\DivisiController;
use App\Http\Controllers\Presensi\SubDivisiController;
use App\Http\Controllers\Presensi\PosisiController;
use App\Http\Controllers\Comprof\SubMenuController;
use App\Http\Controllers\Comprof\DataStafController;
use App\Http\Controllers\Inventory\KelompokprodukController;
use App\Http\Controllers\Inventory\SatuanprodukController;
use App\Http\Controllers\Inventory\DataprodukController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutasiGudang\WarehouseController;




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


// Data Karyawan
Route::resource('divisi', DivisiController::class)
    ->parameters(['divisi' => 'Divisi']);

// Data Sub-Divisi
Route::resource('subdivisi', SubDivisiController::class)
    ->parameters(['subdivisi' => 'SubDivisi']);

// Data Posisi
Route::resource('posisi', PosisiController::class)
    ->parameters(['posisi' => 'Posisi']);

// Data Karyawan
Route::resource('data-karyawan', KaryawanController::class)
    ->parameters(['data-karyawan' => 'Employee']);



// Akuntansi routes
Route::prefix('akunting')->group(function () {
// Kode Akuntansi routes
    Route::get('/kodeakunting', [KodeAkuntingController::class, 'index'])->name('kodeakunting.index');
    Route::post('/kodeakunting', [KodeAkuntingController::class, 'store'])->name('kodeakunting.store');
    Route::get('/kodeakunting/{id}/edit', [KodeAkuntingController::class, 'edit'])->name('kodeakunting.edit');
    Route::put('/kodeakunting/{id}', [KodeAkuntingController::class, 'update'])->name('kodeakunting.update');
    Route::delete('/kodeakunting/{id}', [KodeAkuntingController::class, 'destroy'])->name('kodeakunting.destroy');
    Route::get('/kodeakunting/get-subclasses/{classId}', [KodeAkuntingController::class, 'getSubclassesByClass'])->name('kodeakunting.getSubclasses');
});
// Jurnal Umum routes
Route::middleware(['auth'])->group(function () { // Pastikan hanya user terautentikasi
    Route::prefix('akunting')->name('akunting.')->group(function () { // Prefix untuk URL dan nama route
        Route::resource('jurnal-umum', JurnalUmumController::class)->names('jurnalumum');
        // Tambahkan route AJAX helper jika perlu (seperti getNamaPerkiraan)
        Route::get('jurnal-umum/get-nama-perkiraan/{id}', [JurnalUmumController::class, 'getNamaPerkiraan'])->name('jurnalumum.getNamaPerkiraan');
         // Route untuk mendapatkan nomor jurnal baru via AJAX (opsional)
        Route::get('jurnal-umum/get-next-no', [JurnalUmumController::class, 'create'])->name('jurnalumum.getNextNo');
    });
});


// Inventory routes
Route::prefix('inventory')->group(function () {
    // Supplier routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    // Kelompok Produk routes
    Route::get('/kelompokproduk', [KelompokprodukController::class, 'index'])->name('kelompokproduk.index');
    Route::post('/kelompokproduk', [KelompokprodukController::class, 'store'])->name('kelompokproduk.store');
    Route::put('/kelompokproduk/{kelompokproduk}', [KelompokprodukController::class, 'update'])->name('kelompokproduk.update');
    Route::delete('/kelompokproduk/{kelompokproduk}', [KelompokprodukController::class, 'destroy'])->name('kelompokproduk.destroy');

    // Satuan Produk Routes
    Route::get('/satuanproduk', [SatuanprodukController::class, 'index'])->name('satuanproduk.index');
    Route::post('/satuanproduk', [SatuanprodukController::class, 'store'])->name('satuanproduk.store');
    Route::put('/satuanproduk/{satuanproduk}', [SatuanprodukController::class, 'update'])->name('satuanproduk.update');
    Route::delete('/satuanproduk/{satuanproduk}', [SatuanprodukController::class, 'destroy'])->name('satuanproduk.destroy');

   // Data Produk routes
   Route::get('/dataproduk', [DataprodukController::class, 'index'])->name('dataproduk.index');
   Route::post('/dataproduk', [DataprodukController::class, 'store'])->name('dataproduk.store');
   Route::put('/dataproduk/{dataproduk}', [DataprodukController::class, 'update'])->name('dataproduk.update');
   Route::delete('/dataproduk/{dataproduk}', [DataprodukController::class, 'destroy'])->name('dataproduk.destroy');
});
