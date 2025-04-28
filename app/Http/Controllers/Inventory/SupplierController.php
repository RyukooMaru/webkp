<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        return view('inventory.supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers',
            'alamat' => 'required|string',
            'contact_person' => 'required|string|max:100',
            'telp' => 'required|string|max:20|unique:suppliers',
            'email' => 'nullable|email|max:100',
            'tanggal' => 'nullable|date'
        ]);

        // Generate kode supplier automatically
        $lastSupplier = Supplier::orderBy('id', 'desc')->first();
        $newId = $lastSupplier ? $lastSupplier->id + 1 : 1;
        $kodeSupplier = 'SUP-' . str_pad($newId, 5, '0', STR_PAD_LEFT);

        Supplier::create([
            'kode_supplier' => $kodeSupplier,
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'contact_person' => $request->contact_person,
            'telp' => $request->telp,
            'email' => $request->email,
            'tanggal' => $request->tanggal ?? now(),
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'contact_person' => 'required|string|max:100',
            'telp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'contact_person' => $request->contact_person,
            'telp' => $request->telp,
            'email' => $request->email,
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}