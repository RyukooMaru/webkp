<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Akuntansi\JurnalUmumController;
use App\Http\Controllers\Akuntansi\BukuBesarController;
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
Route::middleware(['auth'])->group(function () { // Pastikan hanya user terautentikasi
Route::prefix('akunting')->group(function () {
// Kode Akuntansi routes
    Route::get('/kodeakunting', [KodeAkuntingController::class, 'index'])->name('kodeakunting.index');
    Route::post('/kodeakunting', [KodeAkuntingController::class, 'store'])->name('kodeakunting.store');
    Route::get('/kodeakunting/{id}/edit', [KodeAkuntingController::class, 'edit'])->name('kodeakunting.edit');
    Route::put('/kodeakunting/{id}', [KodeAkuntingController::class, 'update'])->name('kodeakunting.update');
    Route::delete('/kodeakunting/{id}', [KodeAkuntingController::class, 'destroy'])->name('kodeakunting.destroy');
    Route::get('/kodeakunting/get-subclasses/{classId}', [KodeAkuntingController::class, 'getSubclassesByClass'])->name('kodeakunting.getSubclasses');

// Jurnal Umum routes
    Route::resource('jurnal-umum', JurnalUmumController::class)->names('jurnalumum');
    // Tambahkan route AJAX helper jika perlu (seperti getNamaPerkiraan)
    Route::get('jurnal-umum/get-nama-perkiraan/{id}', [JurnalUmumController::class, 'getNamaPerkiraan'])->name('jurnalumum.getNamaPerkiraan');
    // Route untuk mendapatkan nomor jurnal baru via AJAX (opsional)
    Route::get('jurnal-umum/get-next-no', [JurnalUmumController::class, 'create'])->name('jurnalumum.getNextNo');

// Buku Besar routes
    Route::get('/akunting/buku-besar', [BukuBesarController::class, 'index'])->name('bukubesar.index');
    Route::get('/akunting/buku-besar/pdf', [BukuBesarController::class, 'generatePDF'])->name('akunting.bukubesar.pdf');

    });
});



