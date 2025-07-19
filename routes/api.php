<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AbsensiController; // Asumsi namespace controller API

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Grup rute yang memerlukan otentikasi (misal: Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Endpoint untuk Absensi
    Route::post('/absensi/clock-in', [AbsensiController::class, 'clockIn']);
    Route::post('/absensi/clock-out', [AbsensiController::class, 'clockOut']);
    Route::get('/absensi/status-hari-ini', [AbsensiController::class, 'getTodayStatus']);
});

// Route untuk login (biasanya tidak diproteksi)
// Route::post('/login', [AuthController::class, 'login']);
