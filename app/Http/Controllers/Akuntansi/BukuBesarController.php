<?php

namespace App\Http\Controllers\Akuntansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akuntansi\AccDtJurnal;
use Barryvdh\DomPDF\Facade\Pdf;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        // 1. Hitung total debet dan kredit keseluruhan
        $totalDebetKeseluruhan = AccDtJurnal::sum('debet');
        $totalKreditKeseluruhan = AccDtJurnal::sum('kredit');
        $selisihKeseluruhan = $totalDebetKeseluruhan - $totalKreditKeseluruhan;

        // 2. Ambil data untuk tampilan (dipaginasi)
        $jurnalEntries = AccDtJurnal::with(['header', 'perkiraan'])
            ->select('acc_dt_jurnal.*')
            ->join(
                'acc_hd_jurnal',
                'acc_dt_jurnal.acc_hd_jurnal_id',
                '=',
                'acc_hd_jurnal.id'
            )
            ->orderBy('acc_hd_jurnal.tanggal_buat', 'asc')
            ->orderBy('acc_hd_jurnal.no_jurnal', 'asc')
            ->orderBy('acc_dt_jurnal.id', 'asc')
            ->paginate(25);

        return view('akunting.bukubesar.index', compact(
            'jurnalEntries',
            'totalDebetKeseluruhan',
            'totalKreditKeseluruhan',
            'selisihKeseluruhan'
        ));
    }

    public function generatePDF()
    {
        // 1. Ambil SEMUA data, bukan yang dipaginasi
        $jurnalEntries = AccDtJurnal::with(['header', 'perkiraan'])
            ->select('acc_dt_jurnal.*')
            ->join(
                'acc_hd_jurnal',
                'acc_dt_jurnal.acc_hd_jurnal_id',
                '=',
                'acc_hd_jurnal.id'
            )
            ->orderBy('acc_hd_jurnal.tanggal_buat', 'asc')
            ->orderBy('acc_hd_jurnal.no_jurnal', 'asc')
            ->orderBy('acc_dt_jurnal.id', 'asc')
            ->get(); // Gunakan get() untuk mengambil semua record

        $totalDebetKeseluruhan = $jurnalEntries->sum('debet'); // Hitung dari koleksi yang sudah diambil
        $totalKreditKeseluruhan = $jurnalEntries->sum('kredit');
        $selisihKeseluruhan = $totalDebetKeseluruhan - $totalKreditKeseluruhan;

        $data = [
            'jurnalEntries' => $jurnalEntries,
            'totalDebetKeseluruhan' => $totalDebetKeseluruhan,
            'totalKreditKeseluruhan' => $totalKreditKeseluruhan,
            'selisihKeseluruhan' => $selisihKeseluruhan,
            'tanggalCetak' => now()->translatedFormat('d F Y H:i'), // Tanggal cetak
        ];

        // Muat view dan data ke PDF
        // Parameter kedua adalah nama file PDF saat di-download
        // ->setPaper('a4', 'landscape') untuk orientasi landscape jika tabel lebar
        $pdf = Pdf::loadView('akunting.bukubesar.pdf_view', $data)->setPaper('a4', 'landscape');

        // Opsi 1: Langsung stream PDF ke browser (inline)
        return $pdf->stream('buku-besar-umum-'.date('YmdHis').'.pdf');

        // Opsi 2: Download PDF
        // return $pdf->download('buku-besar-umum-'.date('YmdHis').'.pdf');
    }
}
