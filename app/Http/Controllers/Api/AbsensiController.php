<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi\RealAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Endpoint untuk karyawan melakukan clock in dari mobile.
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $employee = Auth::user();
        $today = Carbon::today();

        // === LOGIKA BARU: VALIDASI JADWAL ===
        $schedule = Jadwal::where('TMP_emp', $employee->emp_Auto)
                          ->where('tmp_periode', $today->format('Y-m'))
                          ->where('emp_tgl', $today->format('d'))
                          ->first();

        if (!$schedule) {
            return response()->json(['message' => 'Anda tidak memiliki jadwal kerja untuk hari ini.'], 404);
        }

        if (in_array($schedule->shift_code, ['L', 'OFF'])) {
            return response()->json(['message' => 'Hari ini adalah hari libur Anda.'], 400);
        }

        // Cek apakah sudah ada absen masuk hari ini
        if (RealAbsensi::where('TS_EMP', $employee->emp_Auto)->where('TS_TANGGAL', $today->toDateString())->exists()) {
            return response()->json(['message' => 'Anda sudah melakukan clock in hari ini.'], 409);
        }
        
        // Simpan file foto
        $fotoPath = basename($request->file('foto')->store('public/absensi_fotos'));

        $attendance = RealAbsensi::create([
            'TS_EMP'        => $employee->emp_Auto,
            'TS_NAME'       => $employee->emp_Name,
            'TS_CODE'       => $employee->emp_Code,
            'TS_TANGGAL'    => $today->toDateString(),
            'TS_JAMIN'      => now()->toTimeString(),
            'TS_FOTO'       => $fotoPath,
            'TS_LATITUDE'   => $request->latitude,
            'TS_LONGITUDE'  => $request->longitude,
            'TS_STATUS'     => 'HADIR',
            'TS_ENTRYDATE'  => now(),
            'TS_ENTRYUSER'  => $employee->emp_Code,
            'TS_ACTIVE'     => 'Y',
        ]);

        return response()->json(['message' => 'Clock in berhasil dicatat.', 'data' => $attendance], 201);
    }

    /**
     * Endpoint untuk karyawan melakukan clock out dari mobile.
     */
    public function clockOut(Request $request)
    {
        $employee = Auth::user();
        $today = Carbon::today()->toDateString();

        // Cari record absen masuk hari ini
        $attendance = RealAbsensi::where('TS_EMP', $employee->emp_Auto)
                                 ->where('TS_TANGGAL', $today)
                                 ->first();

        if (!$attendance) {
            return response()->json(['message' => 'Anda belum melakukan clock in hari ini.'], 404); // 404 Not Found
        }

        if ($attendance->TS_JAMOUT) {
            return response()->json(['message' => 'Anda sudah melakukan clock out hari ini.'], 409);
        }

        // Update jam pulang
        $attendance->update([
            'TS_JAMOUT'     => Carbon::now()->toTimeString(),
            'TS_UPDATEDATE' => now(),
            'TS_UPDATEUSER' => $employee->emp_Code,
        ]);

        return response()->json([
            'message' => 'Clock out berhasil dicatat.',
            'data'    => $attendance
        ]);
    }

    /**
     * Mendapatkan status absensi karyawan untuk hari ini.
     * Berguna agar mobile app tahu tombol apa yang harus ditampilkan (Clock In atau Clock Out).
     */
    public function getTodayStatus(Request $request)
    {
        $employee = Auth::user();
        $today = Carbon::today()->toDateString();
        
        $attendance = RealAbsensi::where('TS_EMP', $employee->emp_Auto)
                                  ->where('TS_TANGGAL', $today)
                                  ->first();

        if (!$attendance) {
            return response()->json(['status' => 'belum_absen', 'message' => 'Siap untuk clock in.']);
        }
        
        if ($attendance && !$attendance->TS_JAMOUT) {
            return response()->json([
                'status' => 'sudah_masuk',
                'message' => 'Sudah clock in, siap untuk clock out.',
                'clock_in_time' => $attendance->TS_JAMIN,
            ]);
        }

        return response()->json([
            'status' => 'selesai',
            'message' => 'Absensi hari ini sudah lengkap.',
            'clock_in_time' => $attendance->TS_JAMIN,
            'clock_out_time' => $attendance->TS_JAMOUT,
        ]);
    }

    public function submitLeave(Request $request)
    {
        $request->validate([
            'tanggal_izin' => 'required|date',
            'status' => 'required|in:IZIN,SAKIT', // Tentukan tipe yang diizinkan
            'keterangan' => 'required|string|max:250',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $employee = Auth::user();

        // Cek apakah sudah ada absen di tanggal tersebut
        if (RealAbsensi::where('TS_EMP', $employee->emp_Auto)->where('TS_TANGGAL', $request->tanggal_izin)->exists()) {
            return response()->json(['message' => 'Sudah ada data absensi pada tanggal tersebut.'], 409);
        }

        $filePath = null;
        if ($request->hasFile('file_pendukung')) {
            $filePath = $request->file('file_pendukung')->store('public/dokumen_izin');
            $filePath = basename($filePath);
        }

        RealAbsensi::create([
            'TS_EMP' => $employee->emp_Auto,
            'TS_NAME' => $employee->emp_Name,
            'TS_CODE' => $employee->emp_Code,
            'TS_TANGGAL' => $request->tanggal_izin,
            'TS_NOTE' => $request->keterangan,
            'TS_STATUS' => $request->status, // Menggunakan kolom dispensasi untuk status
            'TS_FILE_PENDUKUNG' => $filePath,
            'TS_ENTRYDATE' => now(),
            'TS_ENTRYUSER' => $employee->emp_Code,
            'TS_ACTIVE' => 'Y',
            'TS_RECORD' => 'F',
        ]);

        return response()->json(['message' => 'Pengajuan ' . strtolower($request->status) . ' berhasil dikirim.'], 201);
    }
}
