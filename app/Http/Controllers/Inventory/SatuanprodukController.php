<?php
namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Satuanproduk;
use Illuminate\Http\Request;

class SatuanprodukController extends Controller
{
    public function index()
    {
        $satuanProduks = Satuanproduk::orderBy('UOM_Code')->get();
        return view('inventory.satuanproduk.index', compact('satuanProduks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'UOM_Code' => 'required|string|min:3|unique:m_uom',
        ]);

        // Tambahkan data audit
        $validated['UOM_EntryID'] = auth()->id(); // ID user yang sedang login
        $validated['UOM_Entrydate'] = now();

        Satuanproduk::create($validated);

        return redirect()->route('satuanproduk.index')
            ->with('success', 'Satuan Produk berhasil ditambahkan.');
    }

    public function edit(Satuanproduk $satuanproduk)
    {
        return view('inventory.satuanproduk.edit', compact('satuanproduk'));
    }

    public function update(Request $request, Satuanproduk $satuanproduk)
    {
        $validated = $request->validate([
            'UOM_Code' => 'required|string|min:3|unique:m_uom,UOM_Code,'.$satuanproduk->UOM_Auto.',UOM_Auto',
            'UOM_Amount' => 'required|numeric'
        ]);

        // Tambahkan data audit update
        $validated['UOM_UpdateID'] = auth()->id();
        
        $satuanproduk->update($validated);

        return redirect()->route('satuanproduk.index')
            ->with('success', 'Satuan Produk berhasil diperbarui.');
    }

    public function destroy(Satuanproduk $satuanproduk)
    {
        $satuanproduk->delete();
        
        return redirect()->route('satuanproduk.index')
            ->with('success', 'Satuan produk berhasil dihapus');
    }
}