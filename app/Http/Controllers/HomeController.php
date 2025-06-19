<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // ==========================================================
        //         MEMBUAT DATA DUMMY UNTUK DASHBOARD
        // ==========================================================

        // --- Data untuk Grafik Penjualan per Bulan (Bar Chart) ---
        $salesLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $salesData = [15000000, 18000000, 16500000, 21000000, 25000000, 23500000, 28000000, 31000000, 29000000, 35000000, 41000000, 38000000];

        // --- Data untuk Top 10 Produk (List) ---
        // Kita buat sebagai array of objects, meniru hasil dari query Eloquent
        $topProductsQty = [
            (object)['nama_produk' => 'Laptop Pro 15', 'total_qty' => 152],
            (object)['nama_produk' => 'Mouse Gaming X7', 'total_qty' => 340],
            (object)['nama_produk' => 'Keyboard Mekanikal', 'total_qty' => 210],
            (object)['nama_produk' => 'Monitor 24 Inch', 'total_qty' => 180],
            (object)['nama_produk' => 'Webcam HD 1080p', 'total_qty' => 255],
        ];

        $topProductsNominal = [
            (object)['nama_produk' => 'Laptop Pro 15', 'total_nominal' => 1824000000],
            (object)['nama_produk' => 'Monitor 24 Inch', 'total_nominal' => 540000000],
            (object)['nama_produk' => 'Keyboard Mekanikal', 'total_nominal' => 252000000],
            (object)['nama_produk' => 'Mouse Gaming X7', 'total_nominal' => 153000000],
            (object)['nama_produk' => 'Webcam HD 1080p', 'total_nominal' => 127500000],
        ];

        // --- Data untuk Grafik Pembelian per Bulan (Bar Chart) ---
        // Anda bisa membuat variabel baru dengan cara yang sama seperti penjualan
        $purchaseLabels = $salesLabels; // bisa pakai label bulan yang sama
        $purchaseData = [12000000, 14000000, 13500000, 18000000, 20000000, 19500000, 22000000, 25000000, 24000000, 29000000, 35000000, 31000000];


        // --- Data untuk Grafik Karyawan (Pie & Bar Charts) ---
        $genderLabels = ['Laki-laki', 'Perempuan'];
        $genderValues = [55, 45];

        $departmentLabels = ['IT', 'Marketing', 'Akunting', 'HRD', 'Gudang'];
        $departmentValues = [12, 18, 8, 5, 22];

        $attendanceLabels = ['Masuk', 'Sakit', 'Izin', 'Alfa'];
        $attendanceValues = [92, 2, 3, 1];


        // Mengirim semua data dummy ke view menggunakan compact()
        return view('home', compact(
            'salesLabels',
            'salesData',
            'topProductsQty',
            'topProductsNominal',
            'purchaseLabels',
            'purchaseData',
            'genderLabels',
            'genderValues',
            'departmentLabels',
            'departmentValues',
            'attendanceLabels',
            'attendanceValues'
        ));
    }
}
