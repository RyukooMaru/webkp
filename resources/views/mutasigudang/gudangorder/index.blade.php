@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Pesanan ke Gudang</h1>

    {{-- Tombol Modal --}}
    <div class="mb-3">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus"></i> Tambah Pesanan
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Gudang</h6>
        </div>
    <div class="card-body">
    <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr >
            <th colspan="2" class="text-center align-middle">Permintaan</th>
            <th rowspan="2" class="text-center align-middle">NO#</th>
            <th rowspan="2" class="text-center align-middle">Tgl. Permintaan</th>
            <th rowspan="2" class="text-center align-middle">Bruto</th>
            <th rowspan="2" class="text-center align-middle">Disc</th>
            <th rowspan="2" class="text-center align-middle">Pajak</th>
            <th rowspan="2" class="text-center align-middle">Netto</th>
            <th rowspan="2" class="text-center align-middle">Pengguna</th>
            <th rowspan="2" class="text-center align-middle">Tanggal</th>
        </tr>
        <tr>
            <th>Dari</th>
            <th>Tujuan</th>
        </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->Pur_SupCode ?? '-' }}</td>
                <td>{{ $order->pur_warehouse ?? '-' }}</td>
                <td>{{ $order->pur_ordernumber }}</td>
                <td>{{ \Carbon\Carbon::parse($order->Pur_Date)->format('d-m-Y') }}</td>
                <td>{{ number_format($order->Pur_GrossPrice, 2) }}</td>
                <td>{{ number_format($order->Pur_Discount, 2) }}</td>
                <td>{{ number_format($order->Pur_Taxes, 2) }}</td>
                <td>{{ number_format($order->Pur_NettPrice, 2) }}</td>
                <td>{{ $order->Pur_UpdateID ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($order->Pur_LastUpdate)->format('d F Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('gudangorder.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Permintaan Gudang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6 mb-3">
                  <label>Kode Produk</label>
                  <input type="text" name="pur_ordernumber" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Gudang (Tujuan)</label>
                  <input type="text" name="pur_warehouse" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Permintaan</label>
                  <input type="text" name="pur_emp" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Tanggal Permintaan</label>
                  <input type="date" name="Pur_Date" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Bruto</label>
                  <input type="number" step="0.01" name="Pur_GrossPrice" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Diskon</label>
                  <input type="number" step="0.01" name="Pur_Discount" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Pajak</label>
                  <input type="number" step="0.01" name="Pur_Taxes" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Netto</label>
                  <input type="number" step="0.01" name="Pur_NettPrice" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                  <label>Nama Produk</label>
                  <input type="text" name="Pur_UpdateID" class="form-control">
              </div>
              <div class="col-md-6 mb-3">
                  <label>Tanggal Update</label>
                  <input type="datetime-local" name="Pur_LastUpdate" class="form-control">
              </div>
              <div class="col-12 mb-3">
                  <label>Catatan</label>
                  <textarea name="Pur_Note" class="form-control"></textarea>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

<!-- Script -->
@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});

</script>
@endpush
