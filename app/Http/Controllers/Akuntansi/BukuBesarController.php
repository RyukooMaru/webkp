<?php

namespace App\Http\Controllers\Akuntansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Akuntansi\AccDtJurnal;
use Barryvdh\DomPDF\Facade\Pdf;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $query = AccDtJurnal::with(['header', 'perkiraan']);
        $query->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
            $q->whereHas('header', function ($subQuery) use ($request) {
                $subQuery->whereBetween('tanggal_buat', [$request->start_date, $request->end_date]);
            });
        });
        $query->when($request->filled('referensi'), function ($q) use ($request) {
            $q->whereHas('header', function ($subQuery) use ($request) {
                $subQuery->where('no_jurnal', 'like', '%' . $request->referensi . '%');
            });
        });
        $query->when($request->filled('no_rekening'), function ($q) use ($request) {
            $q->whereHas('perkiraan', function ($subQuery) use ($request) {
                $subQuery->where('cls_kiraid', 'like', '%' . $request->no_rekening . '%');
            });
        });
        $query->when($request->filled('nama_perkiraan'), function ($q) use ($request) {
            $searchTerm = $request->nama_perkiraan;
            $q->where(function ($queryBuilder) use ($searchTerm) {
                $queryBuilder->whereHas('perkiraan', function ($sub) use ($searchTerm) {
                    $sub->where('cls_ina', 'like', '%' . $searchTerm . '%');
                });
                $queryBuilder->orWhere(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('acc_dt_jurnal.kredit', '>', DB::raw('acc_dt_jurnal.debet'));
                    $subQuery->whereHas('perkiraan', function ($perk) {
                        $perk->where(function ($q) {
                            $q->whereRaw('LOWER(d_k) = ?', ['d'])
                            ->orWhereRaw('LOWER(d_k) = ?', ['debet']);
                        });
                    });
                    $subQuery->whereExists(function ($existsQuery) use ($searchTerm) {
                        $existsQuery->select(DB::raw(1))
                            ->from('acc_dt_jurnal as dt2')
                            ->join('acc_kira as perk2', 'dt2.acc_kiraid', '=', 'perk2.id')
                            ->whereRaw('dt2.acc_hd_jurnal_id = acc_dt_jurnal.acc_hd_jurnal_id')
                            ->whereRaw('dt2.debet > dt2.kredit')
                            ->where(function ($finalMatch) use ($searchTerm) {
                                $finalMatch->where('perk2.cls_ina', 'like', '%' . $searchTerm . '%')
                                   ->orWhereRaw("CONCAT('Kas ', perk2.cls_ina) LIKE ?", ['%' . $searchTerm . '%']);
                            });
                    });
                });
            });
        });
        $filteredQuery = clone $query;
        $totalDebetKeseluruhan = $filteredQuery->sum('debet');
        $totalKreditKeseluruhan = $filteredQuery->sum('kredit');
        $selisihKeseluruhan = $totalDebetKeseluruhan - $totalKreditKeseluruhan;
        $jurnalEntries = $query
            ->join('acc_hd_jurnal', 'acc_dt_jurnal.acc_hd_jurnal_id', '=', 'acc_hd_jurnal.id')
            ->select('acc_dt_jurnal.*')
            ->orderBy('acc_hd_jurnal.tanggal_buat', 'asc')
            ->orderBy('acc_hd_jurnal.no_jurnal', 'asc')
            ->orderBy('acc_dt_jurnal.id', 'asc')
            ->paginate(25);
        $headerIds = $jurnalEntries->pluck('acc_hd_jurnal_id')->unique();
        $allJournalDetails = AccDtJurnal::with('perkiraan')
            ->whereIn('acc_hd_jurnal_id', $headerIds)
            ->get()
            ->groupBy('acc_hd_jurnal_id');
        $jurnalEntries->getCollection()->transform(function ($entry) use ($allJournalDetails) {
            // 1. Set Default Nama
            $entry->nama_perkiraan_display = $entry->perkiraan ? $entry->perkiraan->cls_ina : 'Tanpa Nama';

            if (!$entry->perkiraan || !$entry->header) {
                return $entry;
            }

            $valKredit = (float) $entry->kredit;
            $valDebet  = (float) $entry->debet;

            // LOGIKA: Cek jika ini sisi Kredit (Pengeluaran / Sumber Dana)
            if ($valKredit > $valDebet) {
                
                $normalBalance = trim(strtolower($entry->perkiraan->d_k)); 

                // Jika akun normalnya DEBET (misal: Kas) tapi ada di sisi KREDIT
                if ($normalBalance === 'd' || $normalBalance === 'debet') {
                    
                    // Ambil semua detail di jurnal ini
                    $relatedEntries = $allJournalDetails->get($entry->acc_hd_jurnal_id);

                    if ($relatedEntries) {
                        // 1. URUTKAN berdasarkan ID agar urutannya sesuai input (1, 2, 3, 4...)
                        // values() penting untuk mereset key array supaya bisa diakses pakai index angka [0,1,2..]
                        $sortedEntries = $relatedEntries->sortBy('id')->values(); 

                        // 2. Cari posisi index baris saya ($entry) ada di urutan keberapa
                        $myIndex = $sortedEntries->search(function($item) use ($entry) {
                            return $item->id === $entry->id;
                        });

                        $foundPartners = [];

                        // 3. LOOPING KE DEPAN (Mulai dari setelah saya)
                        // Kita cari Debit pasangannya, berhenti kalau ketemu Kredit lagi
                        for ($i = $myIndex + 1; $i < $sortedEntries->count(); $i++) {
                            $nextRow = $sortedEntries[$i];
                            
                            // Cek apakah baris selanjutnya ini Debit?
                            if ((float)$nextRow->debet > (float)$nextRow->kredit) {
                                // Jika DEBIT, berarti ini pasangan saya. Simpan namanya.
                                if ($nextRow->perkiraan) {
                                    $foundPartners[] = $nextRow->perkiraan->cls_ina;
                                }
                            } else {
                                // Jika ketemu KREDIT lagi (misal: 'pn pt'), BERHENTI. 
                                // Itu sudah milik kelompok selanjutnya.
                                break; 
                            }
                        }

                        // 4. Format Teks (Gabungkan nama-nama pasangan)
                        if (count($foundPartners) > 0) {
                            if (count($foundPartners) == 1) {
                                // Cuma 1: "Kas asdwa"
                                $gabunganNama = $foundPartners[0];
                            } else {
                                // Lebih dari 1: "Kas asdwa dan qwerr"
                                $lastItem = array_pop($foundPartners); 
                                $gabunganNama = implode(', ', $foundPartners) . ' dan ' . $lastItem;
                            }

                            $entry->nama_perkiraan_display = 'Kas ' . $gabunganNama;
                        }
                    }
                }
            }

            return $entry;
        });
        return view('akunting.bukubesar.index', compact(
            'jurnalEntries',
            'totalDebetKeseluruhan',
            'totalKreditKeseluruhan',
            'selisihKeseluruhan'
        ));
    }

    // Tambahkan Request $request agar bisa menerima filter dari URL
    public function generatePDF(Request $request)
    {
        // Logika query ini SAMA PERSIS dengan di method index,
        // hanya diakhiri dengan ->get() bukan ->paginate()

        $query = AccDtJurnal::with(['header', 'perkiraan']);

        // APLIKASIKAN FILTER (Sama seperti di atas)
        $query->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
            $q->whereHas('header', function ($subQuery) use ($request) {
                $subQuery->whereBetween('tanggal_buat', [$request->start_date, $request->end_date]);
            });
        });
        $query->when($request->filled('referensi'), function ($q) use ($request) {
            $q->whereHas('header', function ($subQuery) use ($request) {
                $subQuery->where('no_jurnal', 'like', '%' . $request->referensi . '%');
            });
        });
        $query->when($request->filled('no_rekening'), function ($q) use ($request) {
        $q->whereHas('perkiraan', function ($subQuery) use ($request) {
            // GANTI 'no_rekening' menjadi 'cls_kiraid'
            $subQuery->where('cls_kiraid', 'like', '%' . $request->no_rekening . '%');
            });
        });
        $query->when($request->filled('nama_perkiraan'), function ($q) use ($request) {
        $q->whereHas('perkiraan', function ($subQuery) use ($request) {
            // GANTI 'nama_perkiraan' menjadi 'cls_ina'
            $subQuery->where('cls_ina', 'like', '%' . $request->nama_perkiraan . '%');
            });
        });

        // Ambil SEMUA data yang sudah terfilter
        $jurnalEntries = $query->join(
                'acc_hd_jurnal',
                'acc_dt_jurnal.acc_hd_jurnal_id',
                '=',
                'acc_hd_jurnal.id'
            )
            ->select('acc_dt_jurnal.*')
            ->orderBy('acc_hd_jurnal.tanggal_buat', 'asc')
            ->orderBy('acc_hd_jurnal.no_jurnal', 'asc')
            ->orderBy('acc_dt_jurnal.id', 'asc')
            ->get(); // Gunakan get() untuk mengambil semua record yang terfilter

        // Hitung total dari data yang sudah diambil
        $totalDebetKeseluruhan = $jurnalEntries->sum('debet');
        $totalKreditKeseluruhan = $jurnalEntries->sum('kredit');
        $selisihKeseluruhan = $totalDebetKeseluruhan - $totalKreditKeseluruhan;

        $data = [
            'jurnalEntries' => $jurnalEntries,
            'totalDebetKeseluruhan' => $totalDebetKeseluruhan,
            'totalKreditKeseluruhan' => $totalKreditKeseluruhan,
            'selisihKeseluruhan' => $selisihKeseluruhan,
            'tanggalCetak' => now()->translatedFormat('d F Y H:i'),
        ];

        $pdf = Pdf::loadView('akunting.bukubesar.pdf_view', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('buku-besar-umum-'.date('YmdHis').'.pdf');
    }
}
