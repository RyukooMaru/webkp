<?php

namespace App\Http\Controllers\MutasiGudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MutasiGudang\GudangOrder;

class GudangOrderController extends Controller
{
    public function index()
    {
        $orders = GudangOrder::all();
        return view('mutasigudang.gudangorder.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pur_ordernumber' => 'required|unique:th_gudangorder',
            'pur_warehouse' => 'required',
            'pur_emp' => 'required',
            'Pur_Date' => 'required|date',
            'Pur_GrossPrice' => 'required|numeric',
            'Pur_Discount' => 'required|numeric',
            'Pur_Taxes' => 'required|numeric',
            'Pur_NettPrice' => 'required|numeric',
            'Pur_UpdateID' => 'nullable|string',
            'Pur_LastUpdate' => 'nullable|date',
        ]);

        GudangOrder::create($request->all());

        return redirect()->route('gudangorder.index')->with('success', 'Permintaan berhasil disimpan');
    }
}
