<?php

namespace App\Http\Controllers\MutasiGudang;

use App\Http\Controllers\Controller;
use App\Models\MutasiGudang\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('mutasigudang.warehouse.index', compact('warehouses'));
    }

    public function create()
    {
        return view('mutasigudang.warehouse.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'WARE_Name' => 'required|max:50',
            'WARE_Address' => 'nullable|max:50',
            'WARE_Phone' => 'nullable|max:15',
            'WARE_Fax' => 'nullable|max:15',
            'WARE_Email' => 'nullable|email|max:50',
            'WARE_Web' => 'nullable|max:50',
            'ware_note1' => 'nullable|max:50',
            'ware_note2' => 'nullable|max:50',
        ]);

        $request->merge(['WARE_EntryDate' => now()]);
        Warehouse::create($request->all());

        return redirect()->route('warehouse.index')->with('success', 'Warehouse created successfully.');
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('mutasigudang.warehouse.edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        $request->validate([
            'WARE_Name' => 'required|max:50',
            'WARE_Address' => 'nullable|max:50',
            'WARE_Phone' => 'nullable|max:15',
            'WARE_Fax' => 'nullable|max:15',
            'WARE_Email' => 'nullable|email|max:50',
            'WARE_Web' => 'nullable|max:50',
            'ware_note1' => 'nullable|max:50',
            'ware_note2' => 'nullable|max:50',
        ]);

        $warehouse->update($request->all());

        return redirect()->route('warehouse.index')->with('success', 'Warehouse updated successfully.');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted successfully.');
    }
}
