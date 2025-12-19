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

        $defaultWarehouse = Warehouse::orderBy('WARE_Auto')->first();

        // Buat penerimaan baru dengan default values
        $penerimaan = Penerimaan::create([
            'no_penerimaan' => 'RCV-' . date('Ymd') . '-' . Str::random(4),
            'supplier_id' => Supplier::first()->id,
            'po_id' => PurchaseOrder::where('status', 'published')->first()->po_id,
            'tgl_terima' => now(),
            'gudang' => $defaultWarehouse->WARE_Name,
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
            'gudang' => 'required|exists:m_warehouse,WARE_Auto',
            'faktur' => 'required|string|max:50',
            'jatuh_tempo' => 'required|date|after:tgl_terima',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->po_id) {
            $valid = PurchaseOrder::where('id', $request->po_id)
                ->where('supplier_id', $request->supplier_id)
                ->exists();

            if (! $valid) {
                return response()->json([
                    'message' => 'PO tidak sesuai dengan supplier'
                ], 422);
            }
        }

        $warehouse = Warehouse::where('WARE_Auto', $request->WARE_Auto)->first();

        $penerimaan = Penerimaan::create([
            'no_penerimaan' => $request->no_penerimaan,
            'status' => 'draft',
            'supplier_id' => $request->supplier_id,
            'po_id' => $request->po_id,
            'tgl_terima' => $request->tgl_terima,
            'gudang' => $warehouse->WARE_Name,
            'faktur' => $request->faktur,
            'jatuh_tempo' => $request->jatuh_tempo,
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('penerimaan.edit', $penerimaan->penerimaan_id)
        ]);
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
            'locations' => Warehouse::orderBy('WARE_Name')->get(),
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
        'locations' => Warehouse::orderBy('WARE_Name')->get(),
        'title' => 'Edit Penerimaan: ' . $penerimaan->no_penerimaan
    ]);
    }

    public function update(Request $request, Penerimaan $penerimaan)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'po_id' => 'required|exists:purchase_orders,po_id',
            'tgl_terima' => 'required|date',
            'gudang' => 'required',
            'faktur' => 'required|string|max:50',
            'jatuh_tempo' => 'required|date|after:tgl_terima',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->po_id) {
            $valid = PurchaseOrder::where('id', $request->po_id)
                ->where('supplier_id', $request->supplier_id)
                ->exists();

            if (! $valid) {
                return response()->json([
                    'message' => 'PO tidak sesuai dengan supplier'
                ], 422);
            }
        }

        $penerimaan->update($request->all());

        return response()->json(['success' => true]);
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
            'WARE_Auto' => 'required|exists:m_warehouse,WARE_Auto',
            'faktur' => 'required|string|max:50',
            'jatuh_tempo' => 'required|date|after:tgl_terima',
            'catatan' => 'nullable|string'
        ]);

        $warehouse = Warehouse::findOrFail($request->WARE_Auto);

        $penerimaan = Penerimaan::findOrFail($id);
        $penerimaan->update([
            'supplier_id' => $request->supplier_id,
            'po_id' => $request->po_id,
            'tgl_terima' => $request->tgl_terima,
            'gudang' => $warehouse->WARE_Name,
            'faktur' => $request->faktur,
            'jatuh_tempo' => $request->jatuh_tempo,
            'catatan' => $request->catatan
        ]);

        return response()->json(['success' => true]);
    }

    public function POBySupplier($supplierId)
    {
        $pos = PurchaseOrder::where('supplier_id', $supplierId)
            ->select('po_id', 'po_number')
            ->get();

        return response()->json($pos);
    }

    public function productsBySupplier($supplierId)
    {
        $products = Dtproduk::where('supplier_id', $supplierId)
            ->orderBy('nama_produk')
            ->get(['id', 'nama_produk']);

        return response()->json($products);
    }

    public function getProductPrice($product_id)
    {
        $detail = PurchaseOrderDetail::where('product_id', $product_id)
            ->orderBy('created_at', 'desc')
            ->first(); // ⬅️ BUKAN get()

        if (!$detail) {
            return response()->json([
                'harga_beli' => 0,
                'pajak_persen' => 0,
                'diskon_persen' => 0,
                'message' => 'Harga beli belum tersedia'
            ]);
        }

        return response()->json([
            'harga_beli' => $detail->unit_price,
            'pajak_persen' => $detail->tax_percent,
            'diskon_persen' => $detail->discount_percent,
        ]);
    }

    public function storeDetail(Request $request, $penerimaanId, $poId)
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

        $po = PurchaseOrder::findOrFail($poId);

        $isValidProduct = Dtproduk::where('id', $request->product_id)
            ->where('supplier_id', $po->supplier_id)
            ->exists();
            
        if (!$isValidProduct) {
            return response()->json([
                'message' => 'Produk tidak sesuai dengan supplier PO'
            ], 422);
        }

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

    public function updateDetail(Request $request, $poId, $penerimaanId, $detailId)
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

        $po = PurchaseOrder::findOrFail($poId);

        $isValidProduct = Dtproduk::where('id', $request->product_id)
            ->where('supplier_id', $po->supplier_id)
            ->exists();
            
        if (!$isValidProduct) {
            return response()->json([
                'message' => 'Produk tidak sesuai dengan supplier PO'
            ], 422);
        }

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