<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('/products-by-kelompok/{kelompok_id}', function($kelompok_id) {
        $products = App\Models\Inventory\Dtproduk::where('kelompok_id', $kelompok_id)
            ->select('id', 'kode_produk', 'nama_produk', 'harga_beli')
            ->get();
            
        return response()->json($products);
    });
});
