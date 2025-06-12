<?php

namespace App\Http\Controllers\Presensi;
use App\Http\Controllers\Controller;
use App\Models\Presensi\Divisi;
use App\Models\Presensi\SubDivisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Divisis = Divisi::all();
        $SubDivisis = SubDivisi::all(); 

        return view('presensi.divisi.index', compact('Divisis', 'SubDivisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Div_Code'      => 'required|string|max:20',
            'Div_Name'      => 'required|string|max:50',
            'DIV_NIK'       => 'nullable|string|max:20',
            'DIV_SHIFTYN'   => 'required|in:Y,T',
            'DIV_BIAYA'     => 'nullable|in:Y,T',
        ]);
        
        $validated['Div_EntryID'] = Auth::user()->id;
        $validated['Div_Entrydate'] = now();


        Divisi::create($validated);


        return redirect()->route('divisi.index')->with('success', 'Data divisi berhasil ditambahkan.');


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
    // public function edit(Divisi $Divisi)
    // {
    //     return view('presensi.divisi', compact('Divisi'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Divisi $Divisi)
    {


        $validated = $request->validate([
            'Div_Code'      => 'required|string|max:20',
            'Div_Name'      => 'nullable|string|max:50',
            'DIV_NIK'       => 'nullable|string|max:20',
            'DIV_SHIFTYN'   => 'required|in:Y,T',
            'DIV_BIAYA'     => 'nullable|in:Y,T',
        ]);
        

        $validated['Div_UserID'] = Auth::user()->id;
        $validated['Div_LastUpdate'] = now();
    
        
        $Divisi->update($validated);

        return redirect()->route('divisi.index')->with('success', 'Data divisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Divisi = Divisi::findOrFail($id);
        $Divisi->delete();
    
        return redirect()->route('divisi.index')->with('success', 'Data divisi berhasil dihapus.');
    }
}
