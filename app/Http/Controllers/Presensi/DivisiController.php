<?php

namespace App\Http\Controllers\Presensi;
use App\Http\Controllers\Controller;
use App\Models\ts_div;
use Illuminate\Http\Request;


class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ts_divs = ts_div::all();

        return view('data-karyawan.index', compact('ts_divs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data-karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ts_div::create($request->all());
        return redirect()->route('data-karyawan.index');
        // ts_div::create([
        //     'name' => $request->input('name'),
        // ]);
        // return redirect()->route('divisi.index');

    }

    // public function massUpdate(Request $request)
    // {
    //     foreach ($request->input('ts_div') as $id => $data) {
    //         $ts_div = ts_div::find($id);
    //         if ($ts_div) {
    //             $ts_div->update($data);
    //         }
    //     }

    //     return redirect()->route('divisi.index')->with('success', 'Data berhasil diperbarui!');
    // }

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
    public function edit(ts_div $ts_div)
    {
        return view('data-karyawan.edit', compact('ts_div'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ts_div $ts_div)
    {
        $data = $request->all();
        $data['Div_UserID'] = Auth::user()->id ?? 'test';; // atau Auth::user()->name, tergantung field
        $data['Div_LastUpdate'] = now();

        $ts_div->update($data);
        return redirect()->route('data-karyawan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ts_div $ts_div)
    {
        $ts_div->delete();

        return redirect()->route('data-karyawan.index');
    }
}
