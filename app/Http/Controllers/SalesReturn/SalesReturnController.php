<?php

namespace App\Http\Controllers\SalesReturn;

use App\Http\Controllers\Controller;
use App\Models\SalesReturn\SalesReturnHeader;
use App\Models\SalesReturn\SalesReturnDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesReturnController extends Controller
{
    public function index()
    {
        $returns = SalesReturnHeader::with('details')->get();
        return view('sales-returns.index', compact('returns'));
    }

    public function data(Request $request)
    {
        $q = SalesReturnHeader::query()->latest('Trx_Auto');

        $q = SalesReturnHeader::query();

        // Filter tanggal
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $q->whereBetween('Trx_Date', [$request->date_start, $request->date_end]);
        }

        // Filter keyword
        if ($kw = $request->keyword) {
            $q->where(fn($q) => $q->where('Trx_SupCode', 'like', "%$kw%")
                ->orWhere('trx_number', 'like', "%$kw%"));
        }

        // Biarkan DataTables menangani ordering & searching
        return DataTables::of($q)
            ->make(true);
    }

    public function create()
    {
        return view('sales-returns.create', ['header' => null, 'details' => []]);
    }

    public function store(Request $request)
    {
        $h = SalesReturnHeader::create($request->validate([
            'trx_number' => 'required|unique:sales_return_headers,trx_number',
            'Trx_Date' => 'required|date',
            // ... tambah validasi sesuai kebutuhan
        ]));
        // Simpan detail
        foreach ($request->input('details', []) as $d) {
            SalesReturnDetail::create($d + ['trx_number' => $h->trx_number]);
        }
        return redirect()->route('sales-returns.index');
    }

    public function edit(SalesReturnHeader $sales_return)
    {
        return view('sales-returns.edit', [
            'header' => $sales_return,
            //'details' => $sales_return->details
        ]);
    }

    public function update(Request $request, SalesReturnHeader $sales_return)
    {
        $sales_return->update($request->validate([
            'trx_number' => "required|unique:sales_return_headers,trx_number,{$sales_return->Trx_Auto},Trx_Auto",
            'Trx_Date' => 'required|date',
        ]));
        return redirect()->route('sales-returns.index');
    }

    public function destroy(SalesReturnHeader $sales_return)
    {
        $sales_return->delete();
        return back();
    }

    public function print(Request $request)
    {
        $q = SalesReturnHeader::query();

        // 1) Filter tanggal
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $q->whereBetween('Trx_Date', [
                $request->date_start,
                $request->date_end,
            ]);
        }

        // 2) Filter kata kunci
        if ($kw = $request->keyword) {
            $q->where(function ($q) use ($kw) {
                $q->where('Trx_SupCode', 'like', "%{$kw}%")
                    ->orWhere('trx_number', 'like',   "%{$kw}%");
            });
        }

        // 3) Urutkan sesuai No# (trx_number) jika diinginkan
        $q->orderBy('trx_number', 'asc');

        $headers = $q->get();
        $pdf     = Pdf::loadView('sales-returns.print', compact('headers'));
        return $pdf->download('retur-penjualan.pdf');
    }
}
