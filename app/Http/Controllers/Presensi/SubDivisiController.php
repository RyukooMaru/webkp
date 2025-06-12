<?php

namespace App\Http\Controllers\Presensi;
use App\Http\Controllers\Controller;
use App\Models\Presensi\Divisi;
use App\Models\Presensi\SubDivisi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class SubDivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SubDivisis = SubDivisi::all();
        $Divisis = Divisi::all();
        return view('presensi.divisi.index', compact('SubDivisis', 'Divisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'div_divcode'   => 'required|string|max:4',
            'Div_Code'      => 'required|string|max:20',
            'Div_Name'      => 'required|string|max:50',
            'DIV_NIK'       => 'nullable|string|max:20',
        ]);
        
        $validated['Div_EntryID'] = Auth::user()->id;
        $validated['Div_Entrydate'] = now();

        SubDivisi::create($validated);

        return redirect()->route('divisi.index')->with('success', 'Data Sub-divisi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubDivisi $SubDivisi)
    {
        $validated = $request->validate([
            'div_divcode'   => 'required|string|max:4',
            'Div_Code'      => 'required|string|max:20',
            'Div_Name'      => 'required|string|max:50',
            'DIV_NIK'       => 'nullable|string|max:20',
        ]);
        
        $validated['Div_UserID'] = Auth::user()->id;
        $validated['Div_LastUpdate'] = now();

        $SubDivisi->update($validated);

        return redirect()->route('divisi.index')->with('success', 'Data Sub-divisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $SubDivisi = SubDivisi::findOrFail($id);
        $SubDivisi->delete();
        
        return redirect()->route('divisi.index')->with('success', 'Data Sub-divisi berhasil dihapus.');

    }
}
