<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Presensi\RealAbsensi;
use App\Models\Presensi\Employee;
use App\Models\Presensi\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $Absensis = RealAbsensi::with('employee')->latest('TS_TANGGAL')->get();
        $employees = Employee::orderBy('emp_Name')->get();
        return view('presensi.absensi.index', compact('Absensis', 'employees'));
    }

    public function show($id)
    {
        $absensi = RealAbsensi::with('employee')->findOrFail($id);
        return response()->json($absensi);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'TS_EMP' => 'required|exists:m_employee,emp_Auto',
            'TS_TANGGAL' => 'required|date',
            'TS_JAMIN' => 'nullable|date_format:H:i',
            'TS_JAMOUT' => 'nullable|date_format:H:i|after_or_equal:TS_JAMIN',
            'TS_FOTO' => 'nullable|image|max:2048',
            'TS_FILE_PENDUKUNG' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'TS_LATITUDE' => 'nullable|numeric',
            'TS_LONGITUDE' => 'nullable|numeric',
            'TS_STATUS' => 'nullable|string',
            'TS_NOTE' => 'nullable|string',
        ]);

        // if (empty($validatedData['TS_STATUS']) || $validatedData['TS_STATUS'] === 'HADIR') {
        //     $date = Carbon::parse($validatedData['TS_TANGGAL']);
        //     $schedule = Jadwal::where('TMP_emp', $validatedData['TS_EMP'])
        //                       ->where('tmp_periode', $date->format('Y-m'))
        //                       ->where('emp_tgl', $date->format('d'))
        //                       ->first();

        //     if (!$schedule) {
        //         // Mengembalikan error validasi jika tidak ada jadwal
        //         return response()->json([
        //             'message' => 'The given data was invalid.',
        //             'errors' => ['TS_TANGGAL' => ['Karyawan tidak memiliki jadwal kerja pada tanggal ini.']]
        //         ], 422);
        //     }

        //     if (in_array($schedule->shift_code, ['L', 'OFF'])) {
        //         // Mengembalikan error validasi jika jadwalnya libur
        //         return response()->json([
        //             'message' => 'The given data was invalid.',
        //             'errors' => ['TS_TANGGAL' => ['Tidak dapat membuat absensi Hadir pada hari libur.']]
        //         ], 422);
        //     }
        // }

        $employee = Employee::find($request->TS_EMP);
        if ($employee) {
            $validatedData['TS_NAME'] = $employee->emp_Name;
            $validatedData['TS_CODE'] = $employee->emp_Code;
        }

        if ($request->hasFile('TS_FOTO')) {
            $validatedData['TS_FOTO'] = basename($request->file('TS_FOTO')->store('public/absensi_fotos'));
        }
        if ($request->hasFile('TS_FILE_PENDUKUNG')) {
            $validatedData['TS_FILE_PENDUKUNG'] = basename($request->file('TS_FILE_PENDUKUNG')->store('public/dokumen_izin'));
        }

        RealAbsensi::create($validatedData);
        return response()->json(['success' => 'Data absensi berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $absensi = RealAbsensi::findOrFail($id);
        return response()->json($absensi);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'TS_EMP' => 'required|exists:m_employee,emp_Auto',
            'TS_TANGGAL' => 'required|date',
            'TS_JAMIN' => 'nullable|date_format:H:i',
            'TS_JAMOUT' => 'nullable|date_format:H:i|after_or_equal:TS_JAMIN',
            'TS_FOTO' => 'nullable|image|max:2048',
            'TS_FILE_PENDUKUNG' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'TS_LATITUDE' => 'nullable|numeric',
            'TS_LONGITUDE' => 'nullable|numeric',
            'TS_STATUS' => 'nullable|string',
            'TS_NOTE' => 'nullable|string',
        ]);

        // if (empty($validatedData['TS_STATUS']) || $validatedData['TS_STATUS'] === 'HADIR') {
        //     $date = Carbon::parse($validatedData['TS_TANGGAL']);
        //     $schedule = Jadwal::where('TMP_emp', $validatedData['TS_EMP'])
        //                       ->where('tmp_periode', $date->format('Y-m'))
        //                       ->where('emp_tgl', $date->format('d'))
        //                       ->first();

        //     if (!$schedule) {
        //         // Mengembalikan error validasi jika tidak ada jadwal
        //         return response()->json([
        //             'message' => 'The given data was invalid.',
        //             'errors' => ['TS_TANGGAL' => ['Karyawan tidak memiliki jadwal kerja pada tanggal ini.']]
        //         ], 422);
        //     }

        //     if (in_array($schedule->shift_code, ['L', 'OFF'])) {
        //         // Mengembalikan error validasi jika jadwalnya libur
        //         return response()->json([
        //             'message' => 'The given data was invalid.',
        //             'errors' => ['TS_TANGGAL' => ['Tidak dapat membuat absensi Hadir pada hari libur.']]
        //         ], 422);
        //     }
        // }

        $absensi = RealAbsensi::findOrFail($id);
        $data = $request->except(['TS_FOTO', 'TS_FILE_PENDUKUNG', 'delete_foto', 'delete_file_pendukung']);

        $employee = Employee::find($request->TS_EMP);
        if ($employee) {
            $data['TS_NAME'] = $employee->emp_Name;
            $data['TS_CODE'] = $employee->emp_Code;
        }

        if ($request->delete_foto == '1' && $absensi->TS_FOTO) {
            Storage::disk('public')->delete('absensi_fotos/' . $absensi->TS_FOTO);
            $data['TS_FOTO'] = null;
        }

        if ($request->hasFile('TS_FOTO')) {
            if ($absensi->TS_FOTO) Storage::disk('public')->delete('absensi_fotos/' . $absensi->TS_FOTO);
            $data['TS_FOTO'] = basename($request->file('TS_FOTO')->store('public/absensi_fotos'));
        }

        if ($request->hasFile('TS_FILE_PENDUKUNG')) {
            if ($absensi->TS_FILE_PENDUKUNG) Storage::disk('public')->delete('dokumen_izin/' . $absensi->TS_FILE_PENDUKUNG);
            $data['TS_FILE_PENDUKUNG'] = basename($request->file('TS_FILE_PENDUKUNG')->store('public/dokumen_izin'));
        }

        $absensi->update($data);
        return response()->json(['success' => 'Data absensi berhasil diperbarui.']);
    }

    public function destroy(RealAbsensi $absensi) // PERBAIKAN: Gunakan Route-Model Binding
    {
        // Hapus file dari storage jika ada
        if ($absensi->TS_FOTO) {
            Storage::disk('public')->delete('absensi_fotos/' . $absensi->TS_FOTO);
        }
        if ($absensi->TS_FILE_PENDUKUNG) {
            Storage::disk('public')->delete('dokumen_izin/' . $absensi->TS_FILE_PENDUKUNG);
        }
        
        $absensi->delete(); // Hapus record dari database

        return response()->json(['success' => 'Data absensi berhasil dihapus.']);
    }
}
