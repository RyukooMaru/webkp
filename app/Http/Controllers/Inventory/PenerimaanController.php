<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Penerimaan;
use App\Models\Inventory\PenerimaanDetail;
use App\Models\Inventory\Supplier;
use App\Models\Inventory\PurchaseOrder;
use App\Models\Inventory\PurchaseOrderDetail;
use App\Models\Inventory\Dtproduk;
use App\Models\Inventory\SatuanProduk;
use App\Models\MutasiGudang\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenerimaanController extends Controller
{
    public function index()
    {
        $penerimaans = Penerimaan::with(['supplier', 'purchaseOrder'])
            ->orderBy('tgl_terima', 'desc')
            ->get();
            
        return view('inventory.penerimaan.index', [
            'penerimaans' => $penerimaans,
            'title' => 'Daftar Penerimaan'
        ]);
    }

    public function create()
    {
        // Validasi ketersediaan data referensi
        if (Supplier::count() === 0) {
            return redirect()->route('supplier.index')
                ->with('error', 'Harap tambahkan supplier terlebih dahulu sebelum membuat penerimaan');
        }

        if (PurchaseOrder::where('status', 'published')->count() === 0) {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Harap buat Purchase Order terlebih dahulu sebelum membuat penerimaan');
        }

        // Buat penerimaan baru dengan default values
        $penerimaan = Penerimaan::create([
            'no_penerimaan' => 'RCV-' . date('Ymd') . '-' . Str::random(4),
            'supplier_id' => Supplier::first()->id,
            'po_id' => PurchaseOrder::where('status', 'published')->first()->po_id,
            'tgl_terima' => now(),
            'gudang' => 'WH-A', // Default gudang
            'faktur' => 'INV-' . date('YmdHis'),
            'jatuh_tempo' => now()->addDays(30),
            'status' => 'draft'
        ]);

        return redirect()->route('penerimaan.edit', $penerimaan->penerimaan_id);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'po_id' => 'required|exists:purchase_orders,po_id',
            'tgl_terima' => 'required|date',
            'WARE_Auto' => 'required|exists:m_warehouse,WARE_Auto',
            'faktur' => 'required|string|max:50',
            'jatuh_tempo' => 'required|date|after:tgl_terima',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $warehouse = Warehouse::where('WARE_Auto', $request->WARE_Auto)->first();

        $penerimaan = Penerimaan::create([
            'no_penerimaan' => $request->no_penerimaan,
            'status' => 'draft',
            'supplier_id' => $request->supplier_id,
            'po_id' => $request->po_id,
            'tgl_terima' => $request->tgl_terima,
            'gudang' => $request->gudang,
            'faktur' => $request->faktur,
            'jatuh_tempo' => $request->jatuh_tempo,
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('penerimaan.edit', $penerimaan->penerimaan_id)
        ]);

        $poSupplier = PurchaseOrder::where('po_id', $request->po_id)->value('supplier_id');

        if ($poSupplier != $request->supplier_id) {
            return response()->json([
                'error' => 'Supplier dan PO tidak cocok'
            ], 422);
        }
    }

    public function show(Penerimaan $penerimaan)
    {
        $penerimaan->load(['details.product', 'details.uom', 'supplier', 'purchaseOrder']);
        
        return view('inventory.penerimaan.index', [
            'header' => $penerimaan,
            'showMode' => true,
            'suppliers' => Supplier::all(),
            'purchaseOrders' => PurchaseOrder::where('status', 'published')->get(),
            'products' => Dtproduk::all(),
            'uoms' => SatuanProduk::all(),
            'locations' => ['WH-A', 'WH-B', 'WH-C'],
            'title' => 'Detail Penerimaan: ' . $penerimaan->no_penerimaan
        ]);
    }

    public function edit(Penerimaan $penerimaan)
    {
    if ($penerimaan->status !== 'draft') {
        return redirect()->route('penerimaan.show', $penerimaan->penerimaan_id)
            ->with('warning', 'Hanya penerimaan dengan status draft yang dapat diedit');
    }

    $penerimaan->load(['details.product', 'details.uom']);

    return view('inventory.penerimaan.index', [
        'header' => $penerimaan,
        // Gunakan unique() untuk menghindari duplikat nama supplier
        'suppliers' => Supplier::orderBy('nama_supplier')->get()->unique('nama_supplier'),
        'purchaseOrders' => PurchaseOrder::where('status', 'published')
            ->orderBy('po_number')
            ->get(),
        'products' => Dtproduk::orderBy('nama_produk')->get(),
        'uoms' => SatuanProduk::orderBy('UOM_Code')->get(),
        'locations' => ['WH-A', 'WH-B', 'WH-C'],
        'title' => 'Edit Penerimaan: ' . $penerimaan->no_penerimaan
    ]);
    }

    public function update(Request $request, Penerimaan $penerimaan)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'po_id' => 'required|exists:purchase_orders,po_id',
            'tgl_terima' => 'required|date',
            'gudang' => 'required|string|max:20',
            'faktur' => 'required|string|max:50',
            'jatuh_tempo' => 'required|date|after:tgl_terima',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $penerimaan->update([
            'supplier_id' => $request->supplier_id_hidden,
            'po_id'       => $request->po_id,
            'tgl_terima'  => $request->tgl_terima,
            'gudang'      => $request->gudang,
            'faktur'      => $request->faktur,
            'jatuh_tempo' => $request->jatuh_tempo,
            'catatan'     => $request->catatan,
        ]);

        return response()->json(['success' => true]);

        $poSupplier = PurchaseOrder::where('po_id', $request->po_id)->value('supplier_id');

        if ($poSupplier != $request->supplier_id) {
            return response()->json([
                'error' => 'Supplier dan PO tidak cocok'
            ], 422);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $penerimaan = Penerimaan::findOrFail($id);
            $penerimaan->details()->delete();
            $penerimaan->delete();
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Penerimaan berhasil dihapus'
        ]);
    }
    
    public function updateHeader(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'po_id' => 'required|exists:purchase_orders,po_id',
            'tgl_terima' => 'required|date',
            'gudang' => 'required|string|max:20',
            'faktur' => 'required|string|max:50',
            'jatuh_tempo' => 'required|date|after:tgl_terima',
            'catatan' => 'nullable|string'
        ]);

        $penerimaan = Penerimaan::findOrFail($id);
        $penerimaan->update($request->all());

        return response()->json(['success' => true]);
    }

    public function getPOBySupplier($supplier_id)
    {
        // Ambil PO berdasarkan supplier
        $poList = PurchaseOrder::where('supplier_id', $supplier_id)
            ->select('po_id', 'po_number')
            ->get();

        return response()->json($poList);
    }

    public function getPODetail($po_id)
    {
        $items = PurchaseOrderDetail::where('po_id', $po_id)
            ->with(['product', 'uom'])
            ->get();

        return response()->json($items);
    }

    public function loadPODetailToPenerimaan(Request $request, $id)
    {
        $po_id = $request->po_id;

        if (!$po_id) {
            return response()->json(['error' => 'PO ID tidak ditemukan'], 422);
        }

        // Cek apakah penerimaan ada
        $penerimaan = Penerimaan::find($id);
        if (!$penerimaan) {
            return response()->json(['error' => 'Penerimaan tidak ditemukan'], 404);
        }

        // Ambil detail PO
        $details = PurchaseOrderDetail::where('po_id', $po_id)->get();

        $penerimaan->update([
            'po_id' => $po_id,
            'supplier_id' => PurchaseOrder::where('po_id', $po_id)->value('supplier_id'),
        ]);

        // Hapus detail lama
        PenerimaanDetail::where('penerimaan_id', $id)->delete();

        foreach ($details as $d) {

            // Hitung ulang subtotal
            $qty = $d->qty;
            $harga = $d->unit_price;
            $diskon = $d->discount_percent;
            $pajak = $d->tax_percent;

            $nilaiBarang = $qty * $harga;
            $nilaiDiskon = $nilaiBarang * ($diskon / 100);
            $nilaiSetelahDiskon = $nilaiBarang - $nilaiDiskon;
            $nilaiPajak = $nilaiSetelahDiskon * ($pajak / 100);

            $subtotal = $nilaiSetelahDiskon + $nilaiPajak;

            // Insert ke tabel penerimaan_detail
            PenerimaanDetail::create([
                'penerimaan_id' => $id,
                'product_id'    => $d->product_id,
                'uom_id'        => $d->uom_id,
                'qty'           => $qty,
                'harga_beli'    => $harga,
                'diskon_persen' => $diskon,
                'pajak_persen'  => $pajak,
                'subtotal'      => $subtotal,
                'catatan'       => $d->catatan,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getDetails($id)
    {
        $details = PenerimaanDetail::where('penerimaan_id', $id)
            ->with(['product', 'uom'])
            ->get()
            ->map(function ($d) {

                return [
                    'detail_id' => $d->id,
                    'qty'       => $d->qty,
                    'unit_price' => $d->harga_beli,
                    'discount_percent' => $d->diskon_persen,
                    'tax_percent' => $d->pajak_persen,
                    'subtotal'   => $d->subtotal,
                    'catatan'    => $d->catatan,

                    // FORMAT JSON SESUAI AJAX
                    'product' => [
                        'kode_produk' => $d->product->kode_produk,
                        'nama_produk' => $d->product->nama_produk,
                    ],
                    'uom' => [
                        'UOM_Code' => $d->uom->UOM_Code,
                    ],
                ];
            });

        return response()->json($details);
    }

    public function storeDetail(Request $request, $penerimaanId)
    {
        $request->validate([
            'product_id' => 'required|exists:dataproduk_tabel,id',
            'uom_id' => 'required|exists:m_uom,UOM_Auto',
            'qty' => 'required|numeric|min:0.01',
            'harga_beli' => 'required|numeric|min:0',
            'pajak_persen' => 'nullable|numeric|min:0|max:100',
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $penerimaanId) {
            // Calculate subtotal
            $subtotal = $request->qty * $request->harga_beli;
            $diskon = $subtotal * ($request->diskon_persen / 100);
            $pajak = ($subtotal - $diskon) * ($request->pajak_persen / 100);
            $total = $subtotal - $diskon + $pajak;

            PenerimaanDetail::create([
                'penerimaan_id' => $penerimaanId,
                'product_id' => $request->product_id,
                'uom_id' => $request->uom_id,
                'qty' => $request->qty,
                'harga_beli' => $request->harga_beli,
                'pajak_persen' => $request->pajak_persen ?? 0,
                'diskon_persen' => $request->diskon_persen ?? 0,
                'subtotal' => $total,
                'catatan' => $request->catatan
            ]);
        });

        return response()->json(['success' => true]);
    }

    public function updateDetail(Request $request, $penerimaanId, $detailId)
    {
        $request->validate([
            'product_id' => 'required|exists:dataproduk_tabel,id',
            'uom_id' => 'required|exists:m_uom,UOM_Auto',
            'qty' => 'required|numeric|min:0.01',
            'harga_beli' => 'required|numeric|min:0',
            'pajak_persen' => 'nullable|numeric|min:0|max:100',
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $penerimaanId, $detailId) {
            $detail = PenerimaanDetail::where('penerimaan_id', $penerimaanId)
                ->where('detail_id', $detailId)
                ->firstOrFail();

            // Recalculate subtotal
            $subtotal = $request->qty * $request->harga_beli;
            $diskon = $subtotal * ($request->diskon_persen / 100);
            $pajak = ($subtotal - $diskon) * ($request->pajak_persen / 100);
            $total = $subtotal - $diskon + $pajak;

            $detail->update([
                'product_id' => $request->product_id,
                'uom_id' => $request->uom_id,
                'qty' => $request->qty,
                'harga_beli' => $request->harga_beli,
                'pajak_persen' => $request->pajak_persen ?? 0,
                'diskon_persen' => $request->diskon_persen ?? 0,
                'subtotal' => $total,
                'catatan' => $request->catatan
            ]);
        });

        return response()->json(['success' => true]);
    }

    public function deleteDetail($penerimaanId, $detailId)
    {
        DB::transaction(function () use ($penerimaanId, $detailId) {
            $detail = PenerimaanDetail::where('penerimaan_id', $penerimaanId)
                ->where('detail_id', $detailId)
                ->firstOrFail();

            $detail->delete();
        });

        return response()->json(['success' => true]);
    }

    public function publish($id)
    {
        $penerimaan = Penerimaan::with('details')->findOrFail($id);
        
        // Validate draft status
        if ($penerimaan->status !== 'draft') {
            return response()->json([
                'error' => 'Hanya penerimaan draft yang bisa dipublish'
            ], 400);
        }

        // Validate header completeness
        if (!$penerimaan->supplier_id || !$penerimaan->po_id || !$penerimaan->tgl_terima || 
            !$penerimaan->gudang || !$penerimaan->faktur || !$penerimaan->jatuh_tempo) {
            return response()->json([
                'error' => 'Lengkapi data header penerimaan terlebih dahulu'
            ], 400);
        }

        // Validate at least one item
        if ($penerimaan->details->isEmpty()) {
            return response()->json([
                'error' => 'Penerimaan harus memiliki minimal 1 item'
            ], 400);
        }

        DB::transaction(function () use ($penerimaan) {
            $penerimaan->update(['status' => 'published']);
            
            // Update stock for each product
            foreach ($penerimaan->details as $detail) {
                $product = Dtproduk::find($detail->product_id);
                if ($product) {
                    $product->qty += $detail->qty;
                    $product->save();
                }
            }
        });

        return response()->json([
            'success' => true,
            'redirect' => route('penerimaan.show', $penerimaan->penerimaan_id)
        ]);
    }

    public function cancel($id)
    {
        DB::transaction(function () use ($id) {
            $penerimaan = Penerimaan::findOrFail($id);
            $penerimaan->details()->delete();
            $penerimaan->delete();
        });
    
        return response()->json([
            'success' => true,
            'redirect' => route('penerimaan.index')
        ]);
    }
}