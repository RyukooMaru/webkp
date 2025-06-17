<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutasiGudang\WarehouseController;
use App\Http\Controllers\MutasiGudang\GudangOrderController;
use App\Http\Controllers\MutasiGudang\TransferGudangController;
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



Route::prefix('mutasigudang')->group(function () {

// Gudang
    Route::resource('warehouse', WarehouseController::class);

// Optional JSON endpoint (untuk AJAX edit)
    Route::get('/{id}/json', [WarehouseController::class, 'json'])->name('json');

// Gudang Order
    Route::resource('gudangorder', GudangOrderController::class);

// Transfer Gudang
    Route::resource('transfergudang', TransferGudangController::class);

});
