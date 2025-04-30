<?php


use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Inventory\SupplierController;
use App\Http\Controllers\Keamanan\RoleController;
use App\Http\Controllers\Presensi\KaryawanController;
use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Inventory\SupplierController;
use App\Http\Controllers\Keamanan\RoleController;
use App\Http\Controllers\SalesReturn\SalesReturnController;
use App\Http\Controllers\Comprof\SettingMenuController;
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







// Presensi
Route::resource('divisi', DivisiController::class)
    ->parameters(['divisi' => 'ts_div']);

// Data Karyawan
Route::resource('data-karyawan', KaryawanController::class)
    ->parameters(['data-karyawan' => 'm_employee']);



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


// Inventory routes
Route::prefix('inventory')->group(function () {
    // Daftar Supplier routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});


// keamanan routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('keamanan/roles')->name('keamanan.role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });
});


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


// Inventory routes
Route::prefix('inventory')->group(function () {
    // Daftar Supplier routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});


// keamanan routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('keamanan/roles')->name('keamanan.role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });
});



Route::resource('warehouse', WarehouseController::class);

// Route untuk DataTables AJAX
Route::get('sales-returns/data', [SalesReturnController::class, 'data'])
    ->name('sales-returns.data');

// Route khusus untuk print PDF
Route::get('sales-returns/print', [SalesReturnController::class, 'print'])
    ->name('sales-returns.print');

// Resource routes tanpa 'show'
Route::resource('sales-returns', SalesReturnController::class)
    ->except(['show']);


// Company Profile routes group
Route::prefix('comprof')->name('comprof.')->group(function () {
    // Menu Management
    Route::resource('settingmenu', SettingMenuController::class)->except(['show']);

    // Other Company Profile routes
    Route::get('settingsubmenu', fn () => view('comprof.settingsubmenu.index'))->name('settingsubmenu.index');
    Route::get('slidesetting', fn () => view('comprof.slidesetting.index'))->name('slidesetting.index');
    Route::get('company', fn () => view('comprof.company.index'))->name('company.index');
    Route::get('staff', fn () => view('comprof.staff.index'))->name('staff.index');
    Route::get('newscategory', fn () => view('comprof.newscategory.index'))->name('newscategory.index');
    Route::get('albumcategory', fn () => view('comprof.albumcategory.index'))->name('albumcategory.index');
});



// Inventory routes
Route::prefix('inventory')->group(function () {
    // Daftar Supplier routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});
