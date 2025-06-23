<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Satuanproduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // If you need to set EntryID/UpdateID with user ID


class SatuanProdukController extends Controller
{
    /**
     * Menampilkan daftar satuan produk.
     */
    public function index()
    {
        $satuanProduks = SatuanProduk::all();
        return view('inventory.satuanproduk.index', compact('satuanProduks'));
    }

    /**
     * Menyimpan satuan produk baru.
     */
    // In app/Http/Controllers/Inventory/SatuanProdukController.php

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'UOM_Code' => 'required|unique:m_uom,UOM_Code|max:5' // <--- USE 'm_uom' HERE
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Data yang diberikan tidak valid.',
            'errors' => $validator->errors()
        ], 422);
    }

    SatuanProduk::create([
        'UOM_Code' => $request->input('UOM_Code'),
        'UOM_Entrydate' => now() // or \Carbon\Carbon::now()
    ]);
    return response()->json([
        'message' => 'Satuan produk berhasil ditambahkan.'
    ], 201);
}

// If you have an update method, do the same for its unique rule:
    public function update(Request $request, SatuanProduk $satuanproduk) // Route Model Binding uses UOM_Auto
    {
        // $satuanproduk is the model instance (e.g., where UOM_Auto = currentId from your JS)

        $primaryKeyColumnName = $satuanproduk->getKeyName(); // This will correctly be 'UOM_Auto'

        $validator = Validator::make($request->all(), [
            'UOM_Code' => 'required|unique:m_uom,UOM_Code,' . $satuanproduk->getKey() . ',' . $primaryKeyColumnName . '|max:5',
            // Add validation for other fields if they are coming from the form
            // 'UOM_Amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $dataToUpdate = [
            'UOM_Code' => $request->input('UOM_Code'),
        ];

        // Optionally set other fields
        if ($request->has('UOM_Amount')) {
            $dataToUpdate['UOM_Amount'] = $request->input('UOM_Amount');
        }
        // If UOM_UpdateID should be the current user's ID
        if (Auth::check()) { // Check if user is authenticated
            $dataToUpdate['UOM_UpdateID'] = Auth::id();
        }

        $satuanproduk->update($dataToUpdate);
        // UOM_LastUpdate will be updated automatically by Laravel (and UOM_Entrydate remains unchanged)

        return response()->json([
            'message' => 'Satuan produk berhasil diperbarui.'
        ], 200);
    }
    /**
     * Menghapus satuan produk.
     */
    public function destroy($id)
    {
        $satuan = Satuanproduk::find($id);

        if (!$satuan) {
            return response()->json([
                'message' => 'Data satuan produk tidak ditemukan'
            ], 404);
        }

        $satuan->delete();

        return response()->json([
            'message' => 'Satuan produk berhasil dihapus'
        ]);
    }
}