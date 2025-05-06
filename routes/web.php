<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Comprof\SettingMenuController;
use App\Http\Controllers\Comprof\SubMenuController;
use App\Http\Controllers\Comprof\DataStafController;
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
    // Setting Menu
    Route::get('/settingmenu', [SettingMenuController::class, 'index'])->name('settingmenu.index');
    Route::post('/settingmenu', [SettingMenuController::class, 'store'])->name('settingmenu.store');
    Route::put('/settingmenu/{settingmenu}', [SettingMenuController::class, 'update'])->name('settingmenu.update');
    Route::delete('/settingmenu/{settingmenu}', [SettingMenuController::class, 'destroy'])->name('settingmenu.destroy');

    // Sub Menu
    Route::get('/settingsubmenu', [SubMenuController::class, 'index'])->name('settingsubmenu.index');
    Route::post('/settingsubmenu', [SubMenuController::class, 'store'])->name('settingsubmenu.store');
    Route::put('/settingsubmenu/{settingsubmenu}', [SubMenuController::class, 'update'])->name('settingsubmenu.update');
    Route::delete('/settingsubmenu/{settingsubmenu}', [SubMenuController::class, 'destroy'])->name('settingsubmenu.destroy');

    // Data Staf
    Route::get('/datastaf', [DataStafController::class, 'index'])->name('datastaf.index');
    Route::post('/datastaf', [DataStafController::class, 'store'])->name('datastaf.store');
    Route::put('/datastaf/{datastaf}', [DataStafController::class, 'update'])->name('datastaf.update');
    Route::delete('/datastaf/{datastaf}', [DataStafController::class, 'destroy'])->name('datastaf.destroy');
});

 
// Inventory routes
Route::prefix('inventory')->group(function () {
    // Daftar Supplier routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});