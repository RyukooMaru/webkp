<?php

use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\SalesReturn\SalesReturnController;
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

// Route untuk DataTables AJAX
Route::get('sales-returns/data', [SalesReturnController::class, 'data'])
    ->name('sales-returns.data');

// Route khusus untuk print PDF
Route::get('sales-returns/print', [SalesReturnController::class, 'print'])
    ->name('sales-returns.print');

// Resource routes tanpa 'show'
Route::resource('sales-returns', SalesReturnController::class)
    ->except(['show']);
