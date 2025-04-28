<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Comprof\SettingMenuController;
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
