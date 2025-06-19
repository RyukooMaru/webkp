<?php

namespace App\Http\Controllers\MutasiGudang;

use Illuminate\Http\Request;
use App\Models\MutasiGudang\TransferGudang;
use App\Models\MutasiGudang\Warehouse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TransferGudangController extends Controller
{
    // Menampilkan halaman utama transfer gudang
    public function index()
    {
    $transfers = TransferGudang::with(['fromWarehouse', 'toWarehouse'])->get();
    $warehouses = Warehouse::all(); // Ambil semua gudang

    return view('mutasigudang.transfergudang.index', compact('transfers','warehouses'));
    }

    // Menyimpan data baru dari form modal
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Transfer_Number' => 'required|unique:th_transfergudang,Transfer_Number',
            'Transfer_FromWarehouse' => 'required|string|max:20',
            'Transfer_ToWarehouse' => 'required|string|max:20',
            'Transfer_Date' => 'required|date',
            'Transfer_ByEmp' => 'nullable|string|max:20',
            'Transfer_Note' => 'nullable|string|max:300',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        TransferGudang::create([
            'Transfer_Number' => $request->Transfer_Number,
            'Transfer_FromWarehouse' => $request->Transfer_FromWarehouse,
            'Transfer_ToWarehouse' => $request->Transfer_ToWarehouse,
            'Transfer_Date' => $request->Transfer_Date,
            'Transfer_ByEmp' => $request->Transfer_ByEmp,
            'Transfer_Note' => $request->Transfer_Note,
            'Transfer_LastUpdate' => Carbon::now(),
        ]);

        return redirect()->route('transfergudang.index')->with('success', 'Transfer gudang berhasil ditambahkan.');
    }

    public function destroy($id)
{
    try {
        $transfer = TransferGudang::findOrFail($id);
        $transfer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transfer Gudang berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menghapus transfer gudang.'
        ], 500);
    }
}

}
