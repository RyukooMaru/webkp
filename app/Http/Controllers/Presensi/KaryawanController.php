<?php

namespace App\Http\Controllers\Presensi;
use App\Http\Controllers\Controller;
use App\Models\Presensi\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Employees = Employee::all();
 
        return view('presensi.data-karyawan.index', compact('Employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presensi.data-karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_Code' => 'nullable|string|max:20|unique:m_employee,emp_Code' . (isset($Employee) ? ',' . $Employee->emp_Auto . ',emp_Auto' : ''),
            'emp_NID' => 'nullable|string|max:30',
            'emp_Name' => 'nullable|string|max:50',
            'emp_ActiveYN' => 'nullable|string|max:1',
            'emp_Address' => 'nullable|string|max:200',
            'emp_CityCode' => 'nullable|string|max:20',
            'emp_ProvinceCode' => 'nullable|string|max:20',
            'emp_DivCode' => 'nullable|string|max:20',
            'EMP_SUBDIVCODE' => 'nullable|string|max:20',
            'emp_PosCode' => 'nullable|string|max:20',
            'emp_ZipCode' => 'nullable|string|max:5',
            'emp_Phone1' => 'nullable|string|max:15',
            'emp_Phone2' => 'nullable|string|max:15',
            'emp_hp1' => 'nullable|string|max:15',
            'emp_hp2' => 'nullable|string|max:15',
            'emp_Address2' => 'nullable|string|max:200',
            'emp_CityCode2' => 'nullable|string|max:20',
            'emp_ProvinceCode2' => 'nullable|string|max:20',
            'emp_ZipCode2' => 'nullable|string|max:5',
            'emp_Phone3' => 'nullable|string|max:15',
            'emp_Phone4' => 'nullable|string|max:15',
            'emp_hp3' => 'nullable|string|max:15',
            'emp_hp4' => 'nullable|string|max:15',
            'emp_Email' => 'nullable|email|max:50',
            'emp_Email2' => 'nullable|email|max:50',
            'emp_Web' => 'nullable|string|max:50',
            'emp_Sex' => 'nullable|string|max:2',
            'emp_Marital' => 'nullable|string|max:2',
            'emp_Religion' => 'nullable|string|max:30',
            'emp_PlaceBorn' => 'nullable|string|max:30',
            'emp_DateBorn' => 'nullable|date',
            'emp_Enroll' => 'nullable|date',
            'emp_startcontract' => 'nullable|date',
            'emp_Expired' => 'nullable|date',
            'emp_permanent' => 'nullable|date',
            'emp_quit' => 'nullable|date',
            'emp_reason' => 'nullable|string|max:3',
            'emp_office' => 'nullable|string|max:10',
            'emp_ptkp' => 'nullable|string|max:10',
            'emp_blood' => 'nullable|string|max:2',
            'EMP_SHIF' => 'nullable|string|max:10',
            'EMP_PAJAK' => 'nullable|string|max:2',
            'EMP_status' => 'nullable|string|max:2',
            'emp_bayar' => 'nullable|string|max:2',
            'emp_BANK' => 'nullable|string|max:10',
            'emp_NOREK' => 'nullable|string|max:20',
            'emp_PEMILIK' => 'nullable|string|max:50',
            'emp_NPWP' => 'nullable|string|max:50',
            'emp_education' => 'nullable|string|max:3',
            'EMP_JAMSOSTEK' => 'nullable|string|max:50',
            'emp_datejamsostek' => 'nullable|date',
            'emp_ktp' => 'nullable|string|max:3',
            'emp_no_ktp' => 'nullable|string|max:30',
            'EMP_PICT' => 'nullable|image|mimes:jpeg,jpg,png|max:8048', 
            'emp_ENTRYID' => 'nullable|string|max:10',
            'emp_FirstEntry' => 'nullable|date',
            'emp_UpdateID' => 'nullable|string|max:10',
            'emp_LastUpdate' => 'nullable|date',
        ]);

        // Tambahkan data user login dan waktu entry
        $validated['emp_ENTRYID'] = Auth::User()->id;
        $validated['emp_FirstEntry'] = Carbon::now();

        if ($request->hasFile('EMP_PICT')) {

            $validated['EMP_PICT'] = file_get_contents($request->file('EMP_PICT'));
        }
    
        Employee::create($validated);
        
        return redirect()->route('data-karyawan.index')->with('success', 'Data Karyawan berhasil ditambahkan.');
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
    public function edit(Employee $Employee)
    {
        return view('presensi.data-karyawan.edit', compact('Employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $Employee)
    {
        $validated = $request->validate([
            'emp_Code' => 'nullable|string|max:20|unique:m_employee,emp_Code' . (isset($Employee) ? ',' . $Employee->emp_Auto . ',emp_Auto' : ''),
            'emp_NID' => 'nullable|string|max:30',
            'emp_Name' => 'nullable|string|max:50',
            'emp_ActiveYN' => 'nullable|string|max:1',
            'emp_Address' => 'nullable|string|max:200',
            'emp_CityCode' => 'nullable|string|max:20',
            'emp_ProvinceCode' => 'nullable|string|max:20',
            'emp_DivCode' => 'nullable|string|max:20',
            'EMP_SUBDIVCODE' => 'nullable|string|max:20',
            'emp_PosCode' => 'nullable|string|max:20',
            'emp_ZipCode' => 'nullable|string|max:5',
            'emp_Phone1' => 'nullable|string|max:15',
            'emp_Phone2' => 'nullable|string|max:15',
            'emp_hp1' => 'nullable|string|max:15',
            'emp_hp2' => 'nullable|string|max:15',
            'emp_Address2' => 'nullable|string|max:200',
            'emp_CityCode2' => 'nullable|string|max:20',
            'emp_ProvinceCode2' => 'nullable|string|max:20',
            'emp_ZipCode2' => 'nullable|string|max:5',
            'emp_Phone3' => 'nullable|string|max:15',
            'emp_Phone4' => 'nullable|string|max:15',
            'emp_hp3' => 'nullable|string|max:15',
            'emp_hp4' => 'nullable|string|max:15',
            'emp_Email' => 'nullable|email|max:50',
            'emp_Email2' => 'nullable|email|max:50',
            'emp_Web' => 'nullable|string|max:50',
            'emp_Sex' => 'nullable|string|max:2',
            'emp_Marital' => 'nullable|string|max:2',
            'emp_Religion' => 'nullable|string|max:30',
            'emp_PlaceBorn' => 'nullable|string|max:30',
            'emp_DateBorn' => 'nullable|date',
            'emp_Enroll' => 'nullable|date',
            'emp_startcontract' => 'nullable|date',
            'emp_Expired' => 'nullable|date',
            'emp_permanent' => 'nullable|date',
            'emp_quit' => 'nullable|date',
            'emp_reason' => 'nullable|string|max:3',
            'emp_office' => 'nullable|string|max:10',
            'emp_ptkp' => 'nullable|string|max:10',
            'emp_blood' => 'nullable|string|max:2',
            'EMP_SHIF' => 'nullable|string|max:10',
            'EMP_PAJAK' => 'nullable|string|max:2',
            'EMP_status' => 'nullable|string|max:2',
            'emp_bayar' => 'nullable|string|max:2',
            'emp_BANK' => 'nullable|string|max:10',
            'emp_NOREK' => 'nullable|string|max:20',
            'emp_PEMILIK' => 'nullable|string|max:50',
            'emp_NPWP' => 'nullable|string|max:50',
            'emp_education' => 'nullable|string|max:3',
            'EMP_JAMSOSTEK' => 'nullable|string|max:50',
            'emp_datejamsostek' => 'nullable|date',
            'emp_ktp' => 'nullable|string|max:3',
            'emp_no_ktp' => 'nullable|string|max:30',
            'EMP_PICT' => 'nullable|image|mimes:jpeg,jpg,png|max:8048',
            'emp_ENTRYID' => 'nullable|string|max:10',
            'emp_FirstEntry' => 'nullable|date',
            'emp_UpdateID' => 'nullable|string|max:10',
            'emp_LastUpdate' => 'nullable|date',
        ]);
    
        // Jika ada upload file baru

        if ($request->hasFile('EMP_PICT')) {
            $validated['EMP_PICT'] = file_get_contents($request->file('EMP_PICT'));
        } elseif ($request->input('hapus_gambar') == '1') {
            $validated['EMP_PICT'] = null;
        } else {
            unset($validated['EMP_PICT']);
        }

        $validated['emp_UpdateID'] = Auth::user()->id; // ID user yang login
        $validated['emp_LastUpdate'] = Carbon::now(); // Timestamp saat update
        
        $Employee->update($validated);
    
        return redirect()->route('data-karyawan.index')->with('success', 'Data Karyawan berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Employee = Employee::findOrFail($id);
        $Employee->delete();
 
        return redirect()->route('data-karyawan.index')->with('success', 'Data Karyawan berhasil dihapus.');;
    }

}
