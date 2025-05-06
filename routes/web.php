<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Inventory\SupplierController;
use App\Http\Controllers\Inventory\KelompokprodukController;
use App\Http\Controllers\Inventory\SatuanprodukController;
use App\Http\Controllers\Inventory\DataprodukController;
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