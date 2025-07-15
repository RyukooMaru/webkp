<?php
namespace App\Http\Controllers\MutasiGudang;

use App\Models\MutasiGudang\TerimaGudang;
use App\Models\MutasiGudang\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TerimaGudangController extends Controller
{
    public function index()
    {
    $td_gudangorder = TerimaGudang::with(['gudangPenerima', 'gudangPengirim']) // <-- PERIKSA INI
                                  ->orderBy('Rec_Auto', 'desc')
                                  ->get();

    $warehouses = Warehouse::all();
    return view('mutasigudang.terimagudang.index', compact('td_gudangorder', 'warehouses'));
    }

    public function store(Request $request)
    {
        // --- DIUBAH ---
        // Validasi disesuaikan dengan kolom database dan nama input di form baru
        $validated = $request->validate([
            'Rec_ordernumber' => 'required|string|max:50|unique:td_gudangorder,Rec_ordernumber', // Nomor penerimaan
            'pur_warehouse'   => 'required|integer',       // Gudang penerima
            'Pur_SupCode'     => 'required|integer',       // Gudang pengirim
            'Pur_Date'        => 'required|date',
            'pur_ordernumber' => 'required|string|max:50', // Nomor permintaan
            'Pur_Note'        => 'nullable|string',
        ]);

        // --- DIUBAH ---
        // Array data disesuaikan dengan nama kolom di database
        $data = [
            'Rec_ordernumber' => $request->Rec_ordernumber,
            'pur_warehouse'   => $request->pur_warehouse,
            'Pur_SupCode'     => $request->Pur_SupCode,
            'Pur_Date'        => $request->Pur_Date,
            'pur_ordernumber' => $request->pur_ordernumber,
            'Pur_Note'        => $request->Pur_Note,
            'Pur_Cancel'      => 'N',
            'Pur_UpdateID'    => Auth::user()->username ?? 'admin',
            'Pur_LastUpdate'  => now(),
        ];

        TerimaGudang::create($data);

        return redirect()->route('terimagudang.index')->with('success', 'Data penerimaan berhasil disimpan');
    }

    public function approve($id)
    {
        // Cari data penerimaan berdasarkan ID-nya (Rec_Auto)
        // Jika tidak ditemukan, akan menampilkan error 404
        $penerimaan = TerimaGudang::findOrFail($id);

        // Update kolom Pur_Cancel menjadi 'Y'
        $penerimaan->update([
            'Pur_Cancel'     => 'Y',
            'Pur_LastUpdate' => now(),
            'Pur_UpdateID'   => Auth::user()->username ?? 'admin', // Sebaiknya update juga siapa yang approve
        ]);

        // TODO: Di sinilah Anda akan menambahkan logika untuk UPDATE STOK GUDANG
        // Contoh:
        // 1. Ambil detail item dari penerimaan ini (jika ada di tabel lain)
        // 2. Tambahkan stok di gudang penerima (pur_warehouse)
        // 3. Kurangi stok di gudang pengirim (Pur_SupCode)

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Data penerimaan ' . $penerimaan->Rec_ordernumber . ' telah di-approve!');
    }

}
