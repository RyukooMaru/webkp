<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Kelompokproduk;
use Illuminate\Http\Request;

class KelompokprodukController extends Controller
{
    public function index()
    {
        $kelompokProduks = Kelompokproduk::orderBy('nama_kelompok')->get();
        return view('inventory.kelompokproduk.index', compact('kelompokProduks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelompok' => 'required|string|max:255|unique:kelompokproduk_tabel'
        ]);

        Kelompokproduk::create($validated);

        return redirect()->route('kelompokproduk.index')
            ->with('success', 'Kelompok Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Kelompokproduk $kelompokproduk)
    {
        $validated = $request->validate([
            'nama_kelompok' => 'required|string|max:255|unique:kelompokproduk_tabel,nama_kelompok,'.$kelompokproduk->id
        ]);

        $kelompokproduk->update($validated);

        return redirect()->route('kelompokproduk.index')
            ->with('success', 'Kelompok Produk berhasil diperbarui.');
    }

    public function destroy(Kelompokproduk $kelompokproduk)
    {
        $kelompokproduk->delete();

        return redirect()->route('kelompokproduk.index')
            ->with('success', 'Kelompok Produk berhasil dihapus.');
    }
}
