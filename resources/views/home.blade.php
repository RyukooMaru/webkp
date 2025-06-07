@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- ===== ANALISIS PENJUALAN ===== -->
    <h4 class="mb-3 text-gray-700">Analisis Penjualan</h4>
    <div class="row">
        <!-- Grafik Penjualan per Bulan -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Penjualan per Bulan (Tahun Ini)</h6></div>
                <div class="card-body">
                    <div class="chart-bar" style="height: 320px;"><canvas id="penjualanBulananChart"></canvas></div>
                </div>
            </div>
        </div>
        <!-- Top 10 Produk -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Top Produk (Berdasarkan QTY)</h6></div>
                <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        @forelse($topProductsQty as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $product->nama_produk }}
                                <span class="badge bg-primary rounded-pill">{{ $product->total_qty }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">Data tidak ditemukan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
             <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Top Produk (Berdasarkan Nominal)</h6></div>
                 <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        @forelse($topProductsNominal as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $product->nama_produk }}</span>
                                <span class="text-success font-weight-bold">Rp {{ number_format($product->total_nominal, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">Data tidak ditemukan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Anda bisa duplikat blok "Analisis Penjualan" ini untuk "Analisis Pembelian" menggunakan variabel $purchaseLabels & $purchaseData --}}
    <hr class="my-4">

    <!-- ===== ANALISIS KARYAWAN ===== -->
    <h4 class="mb-3 text-gray-700">Analisis Karyawan</h4>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Komposisi Gender</h6></div>
                <div class="card-body"><div class="chart-pie pt-4"><canvas id="genderPieChart"></canvas></div></div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                 <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Karyawan per Departemen</h6></div>
                <div class="card-body"><div class="chart-pie pt-4"><canvas id="departmentPieChart"></canvas></div></div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Presensi Hari Ini</h6></div>
                <div class="card-body"><div class="chart-bar"><canvas id="attendanceChart"></canvas></div></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    // Grafik Penjualan
    new Chart(document.getElementById('penjualanBulananChart'), {
        type: 'bar',
        data: { labels: @json($salesLabels), datasets: [{ label: 'Total Penjualan', data: @json($salesData), backgroundColor: 'rgba(78, 115, 223, 0.8)' }] },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { ticks: { callback: (value) => formatRupiah(value) }}}, plugins: { tooltip: { callbacks: { label: (context) => 'Total: ' + formatRupiah(context.parsed.y) }}}}
    });

    // Grafik Gender
    new Chart(document.getElementById('genderPieChart'), {
        type: 'pie',
        data: { labels: @json($genderLabels), datasets: [{ data: @json($genderValues), backgroundColor: ['#4e73df', '#e74a3b'] }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Grafik Departemen
    new Chart(document.getElementById('departmentPieChart'), {
        type: 'pie',
        data: { labels: @json($departmentLabels), datasets: [{ data: @json($departmentValues), backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#858796'] }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Grafik Presensi
    new Chart(document.getElementById('attendanceChart'), {
        type: 'bar',
        data: { labels: @json($attendanceLabels), datasets: [{ label: 'Jumlah Karyawan', data: @json($attendanceValues), backgroundColor: ['#1cc88a', '#f6c23e', '#36b9cc', '#e74a3b'] }] },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { ticks: { precision: 0 }}}}
    });
});
</script>
@endpush
