<?php

namespace App\Http\Controllers;

use App\Models\SPModels\PenjualanDetail; // Pastikan namespace ini benar
use Carbon\Carbon;
use App\Models\Presensi\Employee; // Pastikan model Employee sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // === 1. DATA UNTUK GRAFIK PENJUALAN PER BULAN ===
        $currentYear = Carbon::now()->year;

        $salesByMonth = PenjualanDetail::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(nominal) as total_penjualan')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Siapkan array 12 bulan dengan nilai default 0
        $penjualanBulananData = array_fill(0, 12, 0); // Indeks 0-11 untuk bulan Jan-Des
        foreach ($salesByMonth as $sale) {
            // Indeks array adalah bulan - 1 (Januari=0, Februari=1, dst.)
            $penjualanBulananData[$sale->month - 1] = (int)$sale->total_penjualan;
        }

        // === 2. DATA TOP PRODUK (BERDASARKAN QTY) ===
        $topProductsQty = PenjualanDetail::select(
            'products.nama_produk',
            DB::raw('SUM(penjualan_details.qty) as total_qty')
        )
            // PERBAIKAN: Gunakan nama tabel yang benar 'dataproduk_tabel'
            ->join('dataproduk_tabel as products', 'penjualan_details.product_id', '=', 'products.id')
            ->groupBy('products.nama_produk')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        // === 3. DATA TOP PRODUK (BERDASARKAN NOMINAL) ===
        $topProductsNominal = PenjualanDetail::select(
            'products.nama_produk',
            DB::raw('SUM(penjualan_details.nominal) as total_nominal')
        )
            // PERBAIKAN: Gunakan nama tabel yang benar 'dataproduk_tabel'
            ->join('dataproduk_tabel as products', 'penjualan_details.product_id', '=', 'products.id')
            ->groupBy('products.nama_produk')
            ->orderBy('total_nominal', 'desc')
            ->limit(5)
            ->get();


        // === 2. DATA ANALISIS KARYAWAN (BARU) ===

    // --- Query untuk Komposisi Gender ---
    // Asumsi: kolom emp_Sex berisi 'L' untuk Laki-laki dan 'P' untuk Perempuan
    $genderCounts = Employee::select('emp_Sex', DB::raw('count(*) as total'))
                            ->where('emp_ActiveYN', 'Y') // Hanya hitung karyawan aktif
                            ->groupBy('emp_Sex')
                            ->get();

    // Proses data untuk Chart.js
    $genderLabels = [];
    $genderValues = [];
    foreach ($genderCounts as $count) {
        $genderLabels[] = ($count->emp_Sex == 'L') ? 'Laki-laki' : 'Perempuan';
        $genderValues[] = $count->total;
    }

    // --- Query untuk Karyawan per Departemen ---
    $departmentCounts = Employee::select(
        // Ambil kolom Div_Name dari tabel ts_div dan beri alias 'department_name'
        'divisions.Div_Name as department_name',
        DB::raw('count(m_employee.emp_Auto) as total')
    )
    // Gabungkan (JOIN) dengan tabel ts_div
    // 'ts_div as divisions' -> menggunakan 'divisions' sebagai nama alias sementara untuk tabel ts_div
    ->join('ts_div as divisions', 'm_employee.emp_DivCode', '=', 'divisions.div_Code') // Asumsi foreign key tetap 'div_Code'
    ->where('m_employee.emp_ActiveYN', 'Y')
    ->whereNotNull('m_employee.emp_DivCode')
    ->groupBy('divisions.Div_Name') // Kelompokkan berdasarkan nama departemen
    ->orderBy('total', 'desc')
    ->limit(5)
    ->get();

// Proses data untuk Chart.js (ini sudah benar, mengambil alias 'department_name')
$departmentLabels = $departmentCounts->pluck('department_name')->toArray();
$departmentValues = $departmentCounts->pluck('total')->toArray();


    // === 3. GABUNGKAN SEMUA DATA DALAM SATU RETURN VIEW ===
    return view('home', [
        // Data Analisis Penjualan
        'penjualanBulananData' => $penjualanBulananData,
        'topProductsQty' => $topProductsQty,
        'topProductsNominal' => $topProductsNominal,

        // Data Analisis Karyawan
        'genderLabels' => $genderLabels,
        'genderValues' => $genderValues,
        'departmentLabels' => $departmentLabels,
        'departmentValues' => $departmentValues,

        // Data dummy untuk Presensi (sesuai permintaan "nanti dulu")
        'attendanceLabels' => ['Masuk', 'Sakit', 'Izin', 'Alfa'],
        'attendanceValues' => [0, 0, 0, 0], // Kosongkan dulu
    ]);
}
    }

