<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Inventory\SupplierController;
use App\Http\Controllers\Inventory\KelompokProdukController;
use App\Http\Controllers\Inventory\SatuanProdukController;
use App\Http\Controllers\Inventory\DtprodukController;
use App\Http\Controllers\Inventory\PurchaseOrderController;
use App\Http\Controllers\Inventory\PenerimaanController;
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

    // Satuan Produk routes
    Route::get('/satuanproduk', [SatuanProdukController::class, 'index'])->name('satuanproduk.index');
    Route::post('/satuanproduk', [SatuanProdukController::class, 'store'])->name('satuanproduk.store');
    Route::put('/satuanproduk/{satuanproduk}', [SatuanProdukController::class, 'update'])->name('satuanproduk.update');
    Route::delete('/satuanproduk/{satuanproduk}', [SatuanProdukController::class, 'destroy'])->name('satuanproduk.destroy');

    // Data Produk Routes
    Route::get('/dataproduk', [DtprodukController::class, 'index'])->name('dataproduk.index');
    Route::post('/dataproduk', [DtprodukController::class, 'store'])->name('dataproduk.store');
    Route::get('/dataproduk/{produk}/edit', [DtprodukController::class, 'edit'])->name('dataproduk.edit');
    Route::put('/dataproduk/{produk}', [DtprodukController::class, 'update'])->name('dataproduk.update');
    Route::delete('/dataproduk/{produk}', [DtprodukController::class, 'destroy'])->name('dataproduk.destroy');

    // Purchase Order routes
    Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
    Route::get('/purchase-orders/create', [PurchaseOrderController::class, 'create'])->name('purchase-orders.create');
    Route::get('/purchase-orders/{purchase_order}', [PurchaseOrderController::class, 'show'])->name('purchase-orders.show');
    Route::get('/purchase-orders/{purchase_order}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase-orders.edit');
    Route::delete('/purchase-orders/{purchase_order}', [PurchaseOrderController::class, 'destroy'])->name('purchase-orders.destroy');
    
    // Custom routes untuk operasi PO
    Route::put('/purchase-orders/{id}/update-header', [PurchaseOrderController::class, 'updateHeader'])->name('purchase-orders.update-header');
    Route::post('/purchase-orders/{poId}/details', [PurchaseOrderController::class, 'storeDetail'])->name('purchase-orders.store-detail');
    Route::put('/purchase-orders/{poId}/details/{detailId}', [PurchaseOrderController::class, 'updateDetail'])->name('purchase-orders.update-detail');
    Route::delete('/purchase-orders/{poId}/details/{detailId}', [PurchaseOrderController::class, 'deleteDetail'])->name('purchase-orders.delete-detail');
    Route::post('/purchase-orders/{id}/publish', [PurchaseOrderController::class, 'publish'])->name('purchase-orders.publish');
    Route::delete('/purchase-orders/{id}/cancel', [PurchaseOrderController::class, 'cancel'])->name('purchase-orders.cancel');

    // Penerimaan routes
    Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan.index');
    Route::get('/penerimaan/create', [PenerimaanController::class, 'create'])->name('penerimaan.create');
    Route::post('/penerimaan', [PenerimaanController::class, 'store'])->name('penerimaan.store');
    Route::get('/penerimaan/{penerimaan}', [PenerimaanController::class, 'show'])->name('penerimaan.show');
    Route::get('/penerimaan/{penerimaan}/edit', [PenerimaanController::class, 'edit'])->name('penerimaan.edit');
    Route::put('/penerimaan/{penerimaan}', [PenerimaanController::class, 'update'])->name('penerimaan.update');
    Route::delete('/penerimaan/{penerimaan}', [PenerimaanController::class, 'destroy'])->name('penerimaan.destroy');
        
    // Custom routes untuk operasi Penerimaan
    Route::put('/penerimaan/{id}/update-header', [PenerimaanController::class, 'updateHeader'])->name('penerimaan.update-header');
    Route::post('/penerimaan/{penerimaanId}/details', [PenerimaanController::class, 'storeDetail'])->name('penerimaan.store-detail');
    Route::put('/penerimaan/{penerimaanId}/details/{detailId}', [PenerimaanController::class, 'updateDetail'])->name('penerimaan.update-detail');
    Route::delete('/penerimaan/{penerimaanId}/details/{detailId}', [PenerimaanController::class, 'deleteDetail'])->name('penerimaan.delete-detail');
    Route::post('/penerimaan/{id}/publish', [PenerimaanController::class, 'publish'])->name('penerimaan.publish');
    Route::delete('/penerimaan/{id}/cancel', [PenerimaanController::class, 'cancel'])->name('penerimaan.cancel');
});