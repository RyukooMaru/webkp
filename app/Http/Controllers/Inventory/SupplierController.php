<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Supplier;
use App\Models\Inventory\CaraBayar;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('caraBayar')->orderBy('nama_supplier')->get();
        $caraBayarOptions = CaraBayar::all();
        return view('inventory.supplier.index', compact('suppliers', 'caraBayarOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier' => 'required|string|max:20|unique:suppliers',
            'nama_supplier' => 'required|string|max:255|unique:suppliers',
            'alamat' => 'required|string',
            'contact_person' => 'required|string|max:100',
            'telp' => 'required|string|max:20|unique:suppliers',
            'email' => 'nullable|email|max:100',
            'tanggal' => 'required|date',
            'cara_bayar_id' => 'required|exists:cara_bayar_tabel,id',
            'lama_bayar' => 'nullable|integer|min:0',
            'potongan' => 'nullable|numeric|between:0,100',
        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'alamat' => 'required|string',
            'contact_person' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'cara_bayar_id' => 'required|exists:cara_bayar_tabel,id',
            'lama_bayar' => 'nullable|integer|min:0',
            'potongan' => 'nullable|numeric|between:0,100',
        ];

        // Conditional unique rules
        if ($request->kode_supplier !== $supplier->kode_supplier) {
            $rules['kode_supplier'] = 'required|string|max:20|unique:suppliers';
        }
        if ($request->nama_supplier !== $supplier->nama_supplier) {
            $rules['nama_supplier'] = 'required|string|max:255|unique:suppliers';
        }
        if ($request->telp !== $supplier->telp) {
            $rules['telp'] = 'required|string|max:20|unique:suppliers';
        }

        $request->validate($rules);

        $supplier->update($request->all());

        return response()->json(['success' => true, 'message' => 'Supplier berhasil diperbarui.']);
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplierName = $supplier->nama_supplier;
            $supplier->delete();

            return response()->json([
                'success' => true,
                'message' => 'Supplier ' . $supplierName . ' berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus supplier: ' . $e->getMessage()
            ], 500);
        }
    }
}